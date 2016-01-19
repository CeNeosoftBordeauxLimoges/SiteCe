<?php

namespace Extranet\UtilisateurBundle\Form\Type\Utilisateur;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'read_only' => true
            ))
            ->add('prenom', 'text', array(
                'read_only' => true
            ))
            ->add('nom', 'text', array(
                'read_only' => true
            ))
            ->add('email', 'email', array(
                'required' => true
            ))
            ->add('adresse')
            ->add('ville')
            ->add('codePostal')
            ->add('telPerso');
            //->add('nbEnfants')
           /* ->add('profil', 'textarea', array(
                'required' => false
            ));*/
    }

    public function getName()
    {
        return 'edit_utilisateur_profil';
    }
}