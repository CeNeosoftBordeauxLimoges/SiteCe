<?php

namespace Extranet\MediaBundle\Form\Type\Media;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreateFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'file', array(
                    'file_path'  => 'webPath',
                    'data_class' => null,
                    'label'      => false
                ))
                ->add('path', 'hidden');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Extranet\MediaBundle\Entity\Media',
        ));
    }

    public function getName()
    {
        return 'create_media';
    }

}
