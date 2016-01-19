<?php

namespace Extranet\UtilisateurBundle\Form\Type\Utilisateur;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class EditFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text',array(
                    'required' => true
                ))
                ->add('prenom', 'text',array(
                    'required' => true
                ))
                ->add('nom', 'text',array(
                    'required' => true
                ))
                ->add('email', 'email',array(
                    'required' => true
                ))
                ->add('agence','text',array(
                    'required' => true
                ))
                ->add ('password', 'password',array(
                    'attr' => array("autocomplete" => "off"),
                    'required' => true
                ))
                ->add('groups', 'entity', array(
                    'class' => 'ExtranetUtilisateurBundle:Groupe',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('g')
                            ->orderBy('g.name', 'ASC');
                    },
                    'property' => 'name',
                    'multiple' => true,
                    'required' => true

                ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Extranet\UtilisateurBundle\Entity\Utilisateur',
            'intention'  => 'edit_utilisateur',
        ));
    }

    public function getName()
    {
        return 'edit_utilisateur';
    }

}
