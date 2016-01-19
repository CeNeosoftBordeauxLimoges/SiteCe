<?php

namespace Extranet\MediaBundle\Form\Type\DocumentMedia;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentMediaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('media', new \Extranet\MediaBundle\Form\Type\Media\CreateFormType(), array(
                    'label' => false
                 ))
                 ->add('principale', 'checkbox', array(
                    'required' => false,
                    'label'    => 'Document à partager'
                ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Extranet\MediaBundle\Entity\DocumentMedia',
        ));
    }

    public function getName()
    {
        return 'create_document_media';
    }

}