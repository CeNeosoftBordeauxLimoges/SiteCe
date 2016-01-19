<?php

namespace Extranet\ConcoursBundle\Manager;

use Doctrine\ORM\EntityManager;
use Extranet\ConcoursBundle\Entity\Reponse;
use Psr\Log\LoggerInterface;

class ReponseManager extends BaseManager
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
 
    public function loadAll()
    {
        return $this->getRepository()->findAll();
    }
    
    public function findBy($concours) {
    	return $this->getRepository()->findBy(array('concours'=>$concours));
    }

    /**
     * Remove Reponse entity
     *
     * @param Reponse $reponse
     */
    public function removeReponse(Reponse $reponse)
    {
        return $this->removeAndFlush($reponse);
    }

    /**
     * Save Reponse entity
     *
     * @param Reponse $reponse
     */
    public function saveReponse(Reponse $reponse)
    {
        return $this->persistAndFlush($reponse);
    }

    public function getRepository()
    {
        return $this->em->getRepository('ExtranetConcoursBundle:Reponse');
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