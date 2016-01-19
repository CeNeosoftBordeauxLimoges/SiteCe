<?php

namespace Extranet\UtilisateurBundle\Form\Handler\Utilisateur;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreateHandler
{
    private $form;
    private $container;
    private $request;
    private $utilisateurManager;
    private $clearPassword;
    private $mailer;
    private $noreplyEmail;

    public function __construct(Form $form, Request $request, ContainerInterface $container)
    {
        $this->form = $form;
        $this->request = $request;
        $this->container = $container;
        $this->utilisateurManager = $this->container->get('fos_user.user_manager');
        $this->mailer = $this->container->get('extranet_utilisateur.mailer');
        $this->noreplyEmail = $this->container->getParameter('mailer.noreply.address');
    }

    public function process()
    {
        if ($this->request->getMethod() == 'POST') {
            $this->form->handleRequest($this->request);

            if ($this->form->isValid()) {
                if ($this->onSuccess($this->form->getData())) {

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Génération du mot de passe et enregistrement des données
     *
     * @param \Extranet\UtilisateurBundle\Entity\Utilisateur $utilisateur
     * @return boolean
     */
    public function onSuccess(\Extranet\UtilisateurBundle\Entity\Utilisateur $utilisateur)
    {

        $passwordGenerator = $this->container->get ('extranet_utilisateur.password_generator');

        $this->clearPassword = $passwordGenerator->generate($utilisateur);

        $this->utilisateurManager->updateUser($utilisateur);
        /*
                // message de confirmation de création de l'utilisateur
                $this->container->get('session')->getFlashBag()->add(
                    'success'
                );
        */

        $messages = array();

        // envoi de l'identifiant à l'utilisateur par email
        if (!$this->sendLogin($utilisateur)) {
            $messages[] = "Erreur lors de l'envoi du login<br />";
        }

        // envoi du mot de passe à l'utilisateur par email
        if (!$this->sendPassword($utilisateur)) {
            $messages[] = "erreur lors de l'envoi du mot de passe<br />";
        }

        // message de confirmation d'envoi
        if ( count($messages) == 0) {

            $this->container->get('session')->getFlashBag()->add(
                'success',
                'Identifiant et mot de passe envoyés !'
            );

            return true;
        } else {
            // messages d'erreur
            foreach ($messages as $message) {
                $this->container->get('session')->getFlashBag()->add(
                    'error',
                    $message
                );
            }
        }

        return false;
    }

    /**
     * Envoi de l'identifiant par email
     *
     * @return boolean
     */
    public function sendLogin($utilisateur)
    {
        $templatelogin = $this->container->getParameter('mailer.utilisateur.login.create');
        $messageLogin  = $this->mailer->getMessage($templatelogin, array(
            'utilisateur' => $utilisateur,
            ));
        $messageLogin->setTo($utilisateur->getEmail());
        $messageLogin->setFrom($this->noreplyEmail);

        if ($this->mailer->send($messageLogin)) {

            return true;
        }

        return false;
    }

    /**
     * Envoi du mot de passe par email
     *
     * @return boolean
     */
     public function sendPassword($utilisateur)
    {
        // send password to utilisateur
        $templatePassword = $this->container->getParameter('mailer.utilisateur.password.create');

        $messagePassword = $this->mailer->getMessage($templatePassword, array(
            'utilisateur' => $utilisateur,
            'password'    => $this->clearPassword
            ));
        $messagePassword->setTo($utilisateur->getEmail());
        $messagePassword->setFrom($this->noreplyEmail);

        if ($this->mailer->send($messagePassword)) {

            return true;
        }

        return false;
    }
}
