<?php

namespace Extranet\UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class UtilisateurController extends Controller
{
    public function indexAction()
    {

        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            // Sinon on déclenche une exception « Accès interdit »
            //throw new AccessDeniedException('Accès limité aux admins.');
            $logger = $this->get('logger');
            $logger->info('Logger récupéré');
            $logger->err('Accés non autorisé');

            return $this->redirect($this->generateUrl('extranet_document_homepage'));
        }
        $entities = $this->get('extranet_utilisateur.utilisateur_manager')->loadAll();

        return $this->render('ExtranetUtilisateurBundle:Utilisateur:index.html.twig', array(
            'entities' => $entities
        ));
    }

    public function ajouterAction()
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $entity = $userManager->createUser();

        /*
        $form = $this->createForm(new \Extranet\UtilisateurBundle\Form\Type\Utilisateur\CreateFormType(), $entity , array(
                    'action' => $this->generateUrl('extranet_utilisateur_utilisateur_ajouter'),
                    'method' => 'POST'
                ));

         $formHandler = new \Extranet\UtilisateurBundle\Form\Handler\Utilisateur\CreateHandler(
                 $form,
                 $this->get('request'),
                 $this->container
                 );
        */
        $form = $this->createForm(new \Extranet\UtilisateurBundle\Form\Type\Utilisateur\CreateFormType(),$entity);
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
                {
                    $entity->setEnabled(true);

                    $entity->setPlainPassword($entity->getPassword());

                    //$entity->setPlainPassword('password');

                    $userManager->updateUser($entity);

                    return $this->redirect($this->generateUrl('extranet_utilisateur_utilisateur_homepage'));
                }
        }
        return $this->render('ExtranetUtilisateurBundle:Utilisateur:ajouter.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    public function modifierAction($id)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $entity = $this->get('extranet_utilisateur.utilisateur_manager')->load($id);

        $edit_form = $this->createForm(new \Extranet\UtilisateurBundle\Form\Type\Utilisateur\EditFormType(), $entity);
        $request = $this->getRequest();
       /* $formHandler = new \Extranet\UtilisateurBundle\Form\Handler\Utilisateur\EditHandler(
                $edit_form,
                $this->get('request'),
                $this->container
                ); */
        if ($request->getMethod() == 'POST') {
            $edit_form->bind($request);
            if ($edit_form->isValid()) {

                $entity->setEnabled(true);

                $entity->setPlainPassword($entity->getPassword());

                //$entity->setPlainPassword('password');

                $userManager->updateUser($entity);

                return $this->redirect($this->generateUrl('extranet_utilisateur_utilisateur_homepage'));
            }
        }

        return $this->render('ExtranetUtilisateurBundle:Utilisateur:modifier.html.twig', array(
            'entity'    => $entity,
            'edit_form' => $edit_form->createView()
        ));
    }

    public function supprimerAction($id)
    {
        $utilisateurManager = $this->get('extranet_utilisateur.utilisateur_manager');

        $utilisateur = $utilisateurManager->load($id);

        // message flash
        $type    = null;
        $message = null;

        if ($utilisateurManager->removeUtilisateur($utilisateur)) {
            $type    = "success";
            //$message = 'Utilisateur supprimé !';
        } else {
            $type    = "error";
            $message = 'Erreur lors de la suppression de l\'utilisateur';
        }

        $this->get('session')->getFlashBag()->add($type, $message);

        return $this->redirect($this->generateUrl('extranet_utilisateur_utilisateur_homepage'));
    }
}