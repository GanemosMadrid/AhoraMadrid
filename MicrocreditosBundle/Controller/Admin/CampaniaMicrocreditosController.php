<?php

namespace AhoraMadrid\MicrocreditosBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AhoraMadrid\MicrocreditosBundle\Entity\CampaniaMicrocreditos;
use AhoraMadrid\MicrocreditosBundle\Form\CampaniaMicrocreditosType;

class CampaniaMicrocreditosController extends AdminController{
	
	/**
	 * @Route("/apladmin/editar-campania-microcreditos/{id}", name="editar_campania_microcreditos")
	 */
	public function editarCampania(Request $request, $id){
		//Control de roles
		$response = parent::controlSesion($request, array(parent::ROL_ADMIN));
		if($response != null) return $response;
		
		//Se recoge la campaña de microcréditos
		$em = $this->getDoctrine()->getManager();
		$repoMicro = $em->getRepository('AhoraMadridMicrocreditosBundle:CampaniaMicrocreditos');
		$campania = $repoMicro->find($id);
		
		//Se carga el formulario
		$form = $this->createForm(new CampaniaMicrocreditosType(), $campania);
		$form->handleRequest($request);
		
		if($form->isValid()){
			//Se guarda
			$em->flush();
			
			//Se guarda el mensaje
			$sesion = $this->getRequest()->getSession();
			$sesion->getFlashBag()->add('mensaje', 'La campaÃ±a se ha guardado correctamente');
			
			return $this->redirectToRoute('listar_creditos');
		}
		
		return $this->render('AhoraMadridMicrocreditosBundle:Admin:editar_campania_microcreditos.html.twig', array(
				'form' => $form->createView()
		));
	}
}