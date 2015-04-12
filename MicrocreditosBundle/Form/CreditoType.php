<?php

namespace AhoraMadrid\MicrocreditosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreditoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellidos')
            ->add('documentoIdentidad')
            ->add('correoElectronico')
            ->add('pais')
            ->add('provincia')
            ->add('municipio')
            ->add('codigoPostal')
            ->add('direcccion')
            ->add('importe', 'choice', array(
				'choices' => array(
					'100' => '100 €', 
					'300' => '300 €', 
					'500' => '500 €', 
					'1000' => '1.000 €'
				),
				'expanded' => true,
			))
			->add('Enviar', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AhoraMadrid\MicrocreditosBundle\Entity\Credito'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ahoramadrid_microcreditosbundle_credito';
    }
}
