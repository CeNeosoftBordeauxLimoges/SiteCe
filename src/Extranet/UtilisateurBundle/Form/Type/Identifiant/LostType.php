<?php

namespace Extranet\UtilisateurBundle\Form\Type\Identifiant;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LostType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Extranet\UtilisateurBundle\Entity\Utilisateur',
            'intention'  => 'lost_login',
        ));
    }

    public function getName()
    {
        return 'lost_login';
    }

}
