<?php

namespace AhoraMadrid\MicrocreditosBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swift_Attachment;
use AhoraMadrid\MicrocreditosBundle\Entity\Credito;

class CreditoController extends AdminController{
	
	/**
	 * @Route("/apladmin/listar-creditos", name="listar_creditos")
	 */
	public function listarCreditos(Request $request){
		//Control de roles
		$response = parent::controlSesion($request, array(parent::ROL_ADMIN, parent::ROL_CONSULTA));
		if($response != null) return $response;
		
		//Se crea y se recoge el formulario
		$form = $this->createFormBuilder()
			->setMethod('GET')
	        ->add('identificador', 'text')
	        ->add('nombre', 'text')
	        ->add('apellidos', 'text')
	        ->add('documentoIdentidad', 'text')
	        ->add('Buscar', 'submit')
	        ->getForm();
	
	    $form->handleRequest($request);
	    
	    $data = $form->getData();
		
		//Se buscan los créditos
		$repository = $this->getDoctrine()->getRepository('AhoraMadridMicrocreditosBundle:Credito');
		$qb = $repository->createQueryBuilder('c')
				->orderBy('c.id', 'DESC');
		
		//Se añaden al queryBuilder las opciones del buscador, si las hay
		if($data['identificador'] != null && !empty(trim($data['identificador']))){
			$qb->andWhere('c.identificador LIKE :identificador')
            ->setParameter('identificador', '%'.$data['identificador'].'%');
		}
		
		if($data['nombre'] != null && !empty(trim($data['nombre']))){
			$qb->andWhere('c.nombre LIKE :nombre')
			->setParameter('nombre', '%'.$data['nombre'].'%');
		}
		
		if($data['apellidos'] != null && !empty(trim($data['apellidos']))){
			$qb->andWhere('c.apellidos LIKE :apellidos')
			->setParameter('apellidos', '%'.$data['apellidos'].'%');
		}
		
		if($data['documentoIdentidad'] != null && !empty(trim($data['documentoIdentidad']))){
			$qb->andWhere('c.documentoIdentidad LIKE :documentoIdentidad')
			->setParameter('documentoIdentidad', '%'.$data['documentoIdentidad'].'%');
		}
		
		$query = $qb->getQuery();
		
		$creditos = $query->getResult();
		
		//Se buscan el total del importe de todos
		$qbTotal = $repository->createQueryBuilder('c')
							->select('SUM(c.importe)');
		
		$total = $qbTotal->getQuery()->getSingleScalarResult();
		
		//Se buscan los créditos recibidos
		$qbRecibidos = $repository->createQueryBuilder('c')
							->select('COUNT(c.id)')
							->where('c.recibido = 1');
		
		$recibidos = $qbRecibidos->getQuery()->getSingleScalarResult();
		
		//Se buscan el total del importe de los recibidos
		$qbTotalRecibidos = $repository->createQueryBuilder('c')
		->select('SUM(c.importe)')
		->where('c.recibido = 1');
		
		$totalRecibidos = $qbTotalRecibidos->getQuery()->getSingleScalarResult();
		
		//Paginación
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
				$creditos, $this->get('request')->query->get('page', 1), 25
		);
	
		return $this->render('AhoraMadridMicrocreditosBundle:Admin:listar_creditos.html.twig', array(
				'form' => $form->createView(),
				'pagination' => $pagination,
				'total' => $total,
				'recibidos' => $recibidos,
				'totalRecibidos' => $totalRecibidos
		));
	}
	
	/**
	 * @Route("/apladmin/detalle-credito/{id}", name="detalle_credito")
	 */
	public function detalleCredito(Request $request, $id){
		//Control de roles
		$response = parent::controlSesion($request, array(parent::ROL_ADMIN, parent::ROL_CONSULTA));
		if($response != null) return $response;
		
		//Se buscan el crédito
		$repository = $this->getDoctrine()->getRepository('AhoraMadridMicrocreditosBundle:Credito');
		$credito = $repository->find($id);
		
		return $this->render('AhoraMadridMicrocreditosBundle:Admin:detalle_credito.html.twig', array('credito' => $credito));
	}
	
	/**
	 * @Route("/apladmin/recibir-credito/{id}/{recibir}", name="recibir_credito")
	 */
	public function recibirCredito(Request $request, $id, $recibir){
		//Control de roles
		$response = parent::controlSesion($request, array(parent::ROL_ADMIN));
		if($response != null) return $response;
	
		//Se buscan el crédito
		$em = $this->getDoctrine()->getManager();
		$credito = $em->getRepository('AhoraMadridMicrocreditosBundle:Credito')->find($id);
		$credito->setRecibido($recibir);
		$em->flush();
		
		//Se envía el correo al que ha prestado
		if($recibir == 1){
			$mailer = $this->get('mailer');
			$message = $mailer->createMessage()
			->setSubject('Ahora Madrid: Transferencia recibida')
			->setFrom('contratos@ahoramadrid.org')
			->setTo($credito->getCorreoElectronico())
			->setBody(
					$this->renderView('AhoraMadridMicrocreditosBundle:Admin:correo_transferencia_recibida.txt.twig'),
					'text/plain'
			);
			$mailer->send($message);
		}
		
		//Se guarda el mensaje
		$sesion = $this->getRequest()->getSession();
		$sesion->getFlashBag()->add('mensaje', 'El crédito se ha cambiado de estado correctamente');
	
		return $this->redirectToRoute('listar_creditos');
	}
	
	/**
	 * @Route("/apladmin/borrar-credito/{id}", name="borrar_credito")
	 */
	public function borrarCredito(Request $request, $id){
		//Control de roles
		$response = parent::controlSesion($request, array(parent::ROL_ADMIN));
		if($response != null) return $response;
	
		//Se buscan el crédito
		$em = $this->getDoctrine()->getManager();
		$credito = $em->getRepository('AhoraMadridMicrocreditosBundle:Credito')->find($id);
		$em->remove($credito);
		$em->flush();
	
		//Se guarda el mensaje
		$sesion = $this->getRequest()->getSession();
		$sesion->getFlashBag()->add('mensaje', 'El crédito se ha borrado correctamente');
	
		return $this->redirectToRoute('listar_creditos');
	}
	
}