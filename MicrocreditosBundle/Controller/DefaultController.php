<?php

namespace AhoraMadrid\MicrocreditosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ps\PdfBundle\Annotation\Pdf;

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
	 public function formulario(){
		return $this->render('AhoraMadridMicrocreditosBundle:Default:formulario.html.twig');
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
}
