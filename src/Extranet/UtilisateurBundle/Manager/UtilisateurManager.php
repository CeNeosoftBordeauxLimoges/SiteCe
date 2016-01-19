<?php

namespace Extranet\UtilisateurBundle\Manager;

use Doctrine\ORM\EntityManager;
use Extranet\UtilisateurBundle\Entity\Utilisateur;

class UtilisateurManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function load($id)
    {
        return $this->getRepository()->find($id);
    }

    public function loadByEmail($email)
    {
        return $this->getRepository()->findByEmail($email);
    }

    public function loadAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * Remove Utilisateur entity
     *
     * @param Utilisateur $utilisateur
     */
    public function removeUtilisateur(Utilisateur $utilisateur)
    {
        return $this->removeAndFlush($utilisateur);
    }

    /**
     * Save Utilisateur entity
     *
     * @param Utilisateur $utilisateur
     */
    public function saveUtilisateur(Utilisateur $utilisateur)
    {
        return $this->persistAndFlush($utilisateur);
    }

    public function getRepository()
    {
        return $this->em->getRepository('ExtranetUtilisateurBundle:Utilisateur');
    }

    public function getManager()
    {
        return $this->em;
    }

    public function getConnection()
    {
        return $this->em->getConnection();
    }

    public function getUnitOfWork()
    {
        return $this->em->getUnitOfWork();
    }

    public function encodePassword()
    {

    }

}
