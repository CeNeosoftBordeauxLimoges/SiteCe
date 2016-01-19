<?php

namespace Extranet\ConcoursBundle\Form\Type\Concours;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConcoursType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('titre', 'text', array(
                'required'  => true
            ))
            ->add('description', 'textarea', array(
                'required'  => true
            ))
            ->add('date_limite','date', array(
    				'input'  => 'datetime',
    				'widget' => 'single_text',
            		'required' => true
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Extranet\ConcoursBundle\Entity\Concours'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'extranetconcoursbundle_concours';
    }
}