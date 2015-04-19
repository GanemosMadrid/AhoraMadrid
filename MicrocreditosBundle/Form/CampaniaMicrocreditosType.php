<?php

namespace AhoraMadrid\MicrocreditosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CampaniaMicrocreditosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('finalidad')
            ->add('concepto')
            ->add('objetivo')
            ->add('activa', 'choice', array(
				'choices' => array(
					'1' => 'Sí', 
					'0' => 'No', 
				),
				'expanded' => true,
			))
            ->add('fase')
            ->add('Guardar', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AhoraMadrid\MicrocreditosBundle\Entity\CampaniaMicrocreditos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ahoramadrid_microcreditosbundle_campaniamicrocreditos';
    }
}
