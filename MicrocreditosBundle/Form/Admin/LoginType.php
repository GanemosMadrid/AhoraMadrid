<?php

namespace AhoraMadrid\MicrocreditosBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LoginType extends AbstractType{
	
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('correo')
			->add('contrasena', 'password')
			->add('Enviar', 'submit')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'AhoraMadrid\MicrocreditosBundle\Entity\Usuario'
		));
	}
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return 'ahoramadrid_microcreditosbundle_usuario';
	}
}