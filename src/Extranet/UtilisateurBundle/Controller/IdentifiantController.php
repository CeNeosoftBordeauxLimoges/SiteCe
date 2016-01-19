<?php

namespace Extranet\UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IdentifiantController extends Controller
{
    public function perduAction()
    {
        $form = $this->createForm(new \Extranet\UtilisateurBundle\Form\Type\Identifiant\LostType());

        $request = $this->get('request');

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $data   = $form->getData();
                $entity = $this->get('extranet_utilisateur.utilisateur_manager')->loadByEmail($data->getEmail());

                if ($entity && $this->envoiIdentifiant($entity)) {

                    return $this->redirect($this->generateUrl('fos_user_security_login'));
                }  else {
                    $this->get('session')->getFlashBag()->add(
                        'error',
                        'Adresse email inconnue !'
                    );
                }
            }
        }

        return $this->render('ExtranetUtilisateurBundle:Identifiant:lost.html.twig', array(
            'form'   => $form->createView()
        ));
    }

    /**
     * Envoi de l'identifiant par email
     *
     * @return boolean
     */
    public function envoiIdentifiant($utilisateur)
    {
        $mailer        = $this->get('extranet_utilisateur.mailer');
        $templatelogin = $this->container->getParameter('mailer.utilisateur.login.lost');

        $messageLogin  = $mailer->getMessage($templatelogin, array(
            'utilisateur' => $utilisateur,
            ));
        $messageLogin->setTo($utilisateur->getEmail());
        $messageLogin->setFrom($this->container->getParameter('mailer.noreply.address'));

        if ($mailer->send($messageLogin)) {
            $this->get('session')->getFlashBag()->add(
                'success',
                'Identifiant envoyé !'
            );

            return true;
        }

        // message de confirmation de création de l'utilisateur
        $this->get('session')->getFlashBag()->add(
            'error',
            'Erreur lors de l\'envoi de l\'email !'
        );

        return false;
    }

}