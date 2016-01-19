<?php

namespace Extranet\ConcoursBundle\Manager;

use Doctrine\ORM\EntityManager;
use Extranet\ConcoursBundle\Entity\Concours;
use Psr\Log\LoggerInterface;

class ConcoursManager extends BaseManager
{
    protected $em;
    protected $logger;

    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function load($id)
    {
        return $this->getRepository()->find($id);
    }

    public function loadByUser($id)
    {
        return $this->getRepository()->findByUser($id);
    }

    public function loadAll()
    {
        return $this->getRepository()->findAll();
    }

    public function postAjout (Concours $concours)
    {
        $concours->setDate(new \DateTime());

        $this->get('extranet_concours.concours_manager')->persistAndFlush($concours);
    }

    /**
     * Remove Document entity
     *
     * @param Document $document
     */
    public function removeConcours(Concours $concours)
    {
        return $this->removeAndFlush($concours);
    }

    /**
     * Save Document entity
     *
     * @param Document $document
     */
    public function saveConcours(Concours $concours)
    {
        return $this->persistAndFlush($concours);
    }

    public function getRepository()
    {
        return $this->em->getRepository('ExtranetConcoursBundle:Concours');
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

}