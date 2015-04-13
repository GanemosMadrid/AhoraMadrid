<?php

namespace AhoraMadrid\MicrocreditosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Swift_Attachment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ps\PdfBundle\Annotation\Pdf;
use AhoraMadrid\MicrocreditosBundle\Entity\Credito;
use AhoraMadrid\MicrocreditosBundle\Form\CreditoType;

class DefaultController extends Controller{
    
	/**
     * @Route("/", name="inicio")
     */
	public function indexAction(){
        return $this->render('AhoraMadridMicrocreditosBundle:Default:index.html.twig');
    }
	
	/**
     * @Route("/formulario", name="formulario")
	 * @Pdf()
     */
	 public function formulario(Request $request){
		//Se carga el formulario
		$credito = new Credito();
		$form = $this->createForm(new CreditoType(), $credito);
		$form->handleRequest($request);
		
		//Si la validación es correcta, se persiste el crédito y se redirige a mostrar el contrato
		if ($form->isValid()) {
			$credito->setIdentificador("Temp");
			
			//Se guarda el crédito
			$em = $this->getDoctrine()->getManager();
			$em->persist($credito);
			$em->flush();
			
			//Se crea el identificador de verdad
			$identificador = 'AhoraMadrid'. $credito->getId() . self::stringAleatorio();
			//Se actualiza el identificador
			$em = $this->getDoctrine()->getManager();
			$credito->setIdentificador($identificador);
			$em->flush();
			
			//Se crea el pdf
			$facade = $this->get('ps_pdf.facade');
			$response = new Response();
			$this->render('AhoraMadridMicrocreditosBundle:Default:contrato.pdf.twig', array('credito' => $credito), $response);
			
			$xml = $response->getContent();
			$content = $facade->render($xml);
			
			//Se escribe a disco el pdf
			$ruta = $this->get('kernel')->locateResource('@AhoraMadridMicrocreditosBundle/Resources/contratos/');
			$fs = new Filesystem();
			$fs->dumpFile($ruta . $identificador .'.pdf', $content);
			
			//Se manda el correo
			$mailer = $this->get('mailer');
			$message = $mailer->createMessage()
				->setSubject('Contrato de microcrédito con Ahora Madrid')
				->setFrom('contratos@ahoramadrid.org')
				->setTo($credito->getCorreoElectronico())
				->setBody(
					$this->renderView(
						'AhoraMadridMicrocreditosBundle:Default:correo.txt.twig',
						array('credito' => $credito)
					),
					'text/plain'
				)
				->attach(Swift_Attachment::fromPath($ruta . $identificador .'.pdf'))
			;
			$mailer->send($message);
			
			return $this->redirectToRoute('contrato', array('id' => $credito->getId(), 'identificador' => $credito->getIdentificador()));
		}
		
		//Si no se ha enviado el formulario, se carga la página con el formulario
		return $this->render('AhoraMadridMicrocreditosBundle:Default:formulario.html.twig', array(
                    'form' => $form->createView(),
		));
	 }
	 
	 /**
     * @Route("/contrato/{id}/{identificador}", name="contrato")
     */
	 public function contrato($id, $identificador){
		//Se busca el crédito por su identificador
		$repository = $this->getDoctrine()->getRepository('AhoraMadridMicrocreditosBundle:Credito');
		$credito = $repository->findOneBy(array('id' => $id, 'identificador' => $identificador));
		//Si no se ha encontrado, no se puede crear el pdf. Se muestra la página de eror
		if(!$credito){
			return $this->render('AhoraMadridMicrocreditosBundle:Default:error_contrato.html.twig', array('identificador' => $identificador));
		}
		
        return $this->render('AhoraMadridMicrocreditosBundle:Default:contrato_ok.html.twig', array('credito' => $credito));
		//return new Response($content, 200, array('content-type' => 'application/pdf'));
	 }
	 
	 /**
     * @Route("/pdf/{id}/{identificador}", name="pdf")
	 * @Pdf()
     */
	 public function pdf($id, $identificador){
		//Se busca el crédito por su identificador
		$repository = $this->getDoctrine()->getRepository('AhoraMadridMicrocreditosBundle:Credito');
		$credito = $repository->findOneBy(array('id' => $id, 'identificador' => $identificador));
		//Si no se ha encontrado, no se puede crear el pdf. Se muestra la página de eror
		if(!$credito){
			return $this->render('AhoraMadridMicrocreditosBundle:Default:error_contrato.html.twig', array('identificador' => $identificador));
		}
		
		//Se guarda el crédito
		$em = $this->getDoctrine()->getManager();
		$em->persist($credito);
		$em->flush();
		
		//Se crea el pdf
		$facade = $this->get('ps_pdf.facade');
		$response = new Response();
		$this->render('AhoraMadridMicrocreditosBundle:Default:contrato.pdf.twig', array('credito' => $credito), $response);
		
		$xml = $response->getContent();
		$content = $facade->render($xml);
		
		return new Response($content, 200, array('content-type' => 'application/pdf'));
	 }
	 
	 private function stringAleatorio($length = 3) {
		//$char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$char = str_shuffle($char);
		for($i = 0, $rand = '', $l = strlen($char) - 1; $i < $length; $i ++) {
			$rand .= $char{mt_rand(0, $l)};
		}
		return $rand;
	}
}
