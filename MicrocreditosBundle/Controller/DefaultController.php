<?php

namespace AhoraMadrid\MicrocreditosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     */
	 public function formulario(Request $request){
		$credito = new Credito();
		
		$form = $this->createForm(new CreditoType(), $credito);
		
		$form->handleRequest($request);
		
		if ($form->isValid()) {
			$credito->setIdentificador(self::stringAleatorio());
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($credito);
			$em->flush();
			
			return $this->redirectToRoute('contrato');
		}
		
		return $this->render('AhoraMadridMicrocreditosBundle:Default:formulario.html.twig', array(
                    'form' => $form->createView(),
		));
	 }
	 
	 /**
     * @Route("/contrato", name="contrato")
	 * @Pdf()
     */
	 public function contrato(){
		$facade = $this->get('ps_pdf.facade');
        $response = new Response();
		$this->render('AhoraMadridMicrocreditosBundle:Default:contrato.pdf.twig', array(), $response);
		
		$xml = $response->getContent();
        
        $content = $facade->render($xml);
        
        return new Response($content, 200, array('content-type' => 'application/pdf'));
	 }
	 
	 private function stringAleatorio($length = 10) {
		$char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$char = str_shuffle($char);
		for($i = 0, $rand = '', $l = strlen($char) - 1; $i < $length; $i ++) {
			$rand .= $char{mt_rand(0, $l)};
		}
		return $rand;
	}
}
