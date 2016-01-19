<?php

namespace Extranet\DocumentBundle\Form\Type\Document;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add ('type','text', array(
                'required'  => false
            ))
            ->add('file', 'file', array(
             //   'file_path'  => 'uploadDir',
                'data_class' => null,
                'label'      => 'Ajouter un document',
                'required' => true
            ));

            //->add('path', 'hidden')
            /*
            ->add('active', 'checkbox', array(
                'label'     => 'Actif',
                'required'  => false
            )); */
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Extranet\DocumentBundle\Entity\Document'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'extranetdocumentbundle_document';
    }
}