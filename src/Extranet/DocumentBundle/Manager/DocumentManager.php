<?php

namespace Extranet\DocumentBundle\Manager;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Extranet\DocumentBundle\Entity\Document;

class DocumentManager extends BaseManager
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

    public function postAjout (Document $document)
    {
        $document->setDate(new \DateTime());

        $this->get('extranet_document.document_manager')->persistAndFlush($document);
    }

    /**
     * Remove Document entity
     *
     * @param Document $document
     */
    public function removeDocument(Document $document)
    {
        return $this->removeAndFlush($document);
    }

    /**
     * Save Document entity
     *
     * @param Document $document
     */
    public function saveDocument(Document $document)
    {
        return $this->persistAndFlush($document);
    }

    public function getRepository()
    {
        return $this->em->getRepository('ExtranetDocumentBundle:Document');
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