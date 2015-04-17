<?php

namespace AhoraMadrid\MicrocreditosBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AhoraMadrid\MicrocreditosBundle\Entity\Credito;

class CreditoController extends AdminController{
	
	/**
	 * @Route("/apladmin/listar-creditos", name="listar_creditos")
	 */
	public function listarCreditos(Request $request){
		//Control de roles
		$response = parent::controlSesion($request, array(parent::ROL_ADMIN, parent::ROL_CONSULTA));
		if($response != null) return $response;
		
		//Se buscan los créditos
		$repository = $this->getDoctrine()->getRepository('AhoraMadridMicrocreditosBundle:Credito');
		$qb = $repository->createQueryBuilder('c')
				->orderBy('c.id', 'DESC');
		
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