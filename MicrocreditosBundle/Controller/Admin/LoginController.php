<?php

namespace AhoraMadrid\MicrocreditosBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AhoraMadrid\MicrocreditosBundle\Entity\Usuario;
use AhoraMadrid\MicrocreditosBundle\Form\Admin\LoginType;

class LoginController extends AdminController{
	
	/**
	 * @Route("/apladmin", name="login")
	 */
	public function indexAction(Request $request){
		//Para hacer la contraseña <div>{{ contrasena }}</div>
		//$hash = password_hash('mtdStvJf', PASSWORD_BCRYPT, array('cost' => 8));
		
		//Se carga el formulario
		$usuarioParam = new Usuario();
		$form = $this->createForm(new LoginType(), $usuarioParam);
		$form->handleRequest($request);
		
		//Se hace el login
		$error = "";
		if ($form->isValid()) {
			//Se busca el usuario
			$repository = $this->getDoctrine()->getRepository('AhoraMadridMicrocreditosBundle:Usuario');
			$usuario = $repository->findOneByCorreo($usuarioParam->getCorreo());
			
			if($usuario != null){
				//Si la contraseña es correccta, se guarda el usuario en la sesión y se redirige
				if (password_verify($usuarioParam->getContrasena(), $usuario->getContrasena())) {
					parent::guardarUsuarioSesion($request, $usuario);
					return $this->redirectToRoute('listar_creditos');
				} else {
					$error = "Contraseña incorrecta";
				}
			} else {
				$error = "Usuario incorrecto";
			}
		}
		
		return $this->render('AhoraMadridMicrocreditosBundle:Admin:login.html.twig', array('form' => $form->createView(), 'error' => $error));
		//return $this->render('AhoraMadridMicrocreditosBundle:Admin:login.html.twig', array('form' => $form->createView(), 'error' => $error, 'contrasena' => $hash));
	}
	
	/**
	 * @Route("/apladmin/logout", name="logout")
	 */
	public function logout(Request $request){
		//Se destruye la sesión
		$sesion = $request->getSession();
		$sesion->clear();
		
		//Se redirige al login
		return $this->redirectToRoute('login');
	}
	
}