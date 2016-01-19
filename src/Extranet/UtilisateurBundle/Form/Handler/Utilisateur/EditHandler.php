<?php

namespace Extranet\UtilisateurBundle\Form\Handler\Utilisateur;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EditHandler
{
    private $form;
    private $container;
    private $request;
    private $utilisateurManager;

    public function __construct(Form $form, Request $request, ContainerInterface $container)
    {
        $this->form               = $form;
        $this->request            = $request;
        $this->container          = $container;
        $this->utilisateurManager = $this->container->get('extranet_utilisateur.utilisateur_manager');
    }

    public function process()
    {
        if ($this->request->getMethod() == 'POST') {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {

                $this->onSuccess($this->form->getData());

                return true;
            }
        }

        return false;
    }

    public function onSuccess(\Extranet\UtilisateurBundle\Entity\Utilisateur $utilisateur)
    {
        $changed = false;

        if ($this->usernameChange($utilisateur)) {
           $changed = true;
        }
        if ($this->utilisateurManager->saveUtilisateur($utilisateur)) {
            if (true == $changed) {
                 $this->sendLogin($utilisateur);
            }

            $this->container->get('session')->getFlashBag()->add(
                'notice',
                'modifications enregistrées !');

            return true;
        }

        return false;
    }

    public function usernameChange($utilisateur)
    {
        // Vérifie si le nom d'utilisateur a changé
        $uow = $this->utilisateurManager->getUnitOfWork();
        $uow->computeChangeSets();
        $changeset = $uow->getEntityChangeSet($utilisateur);

        if (array_key_exists('username', $changeset)) {

            return true;
        }

        return false;
    }

    public function sendLogin($utilisateur)
    {
        $mailer       = $this->container->get('extranet_utilisateur.mailer');
        $noreplyEmail = $this->container->getParameter('mailer.noreply.address');

        $templatelogin = $this->container->getParameter('mailer.utilisateur.login.change');
        $messageLogin  = $mailer->getMessage($templatelogin, array(
            'utilisateur' => $utilisateur,
            ));
        $messageLogin->setTo($utilisateur->getEmail());
        $messageLogin->setFrom($noreplyEmail);
        $messageLogin->setReplyTo(array($noreplyEmail));

        if ($mailer->send($messageLogin)) {

            return true;
        }

        return false;
    }
}
