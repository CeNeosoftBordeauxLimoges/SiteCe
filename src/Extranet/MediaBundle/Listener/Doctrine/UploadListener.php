<?php

namespace Extranet\MediaBundle\Listener\Doctrine;

use Symfony\Component\DependencyInjection\ContainerInterface,
    Doctrine\ORM\Event\LifecycleEventArgs;

class UploadListener
{

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     *
     * Set upload folder for each media
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        // get request entity
        $entity = $args->getEntity();

        // check if it's an instance of Media
        if ($entity instanceof \Extranet\MediaBundle\Entity\AnnonceMedia) {
            // set annonce folder
            $entity->getMedia()->setUploadDir($this->container->getParameter('medias.repertoire.annonces'));
        }

        if ($entity instanceof \Extranet\MediaBundle\Entity\DocumentMedia) {
            // set document folder
            $entity->getMedia()->setUploadDir($this->container->getParameter('medias.repertoire.documents'));
        }
    }

    /**
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     *
     * Set upload folder for each media
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        // get request entity
        $entity = $args->getEntity();

        // check if it's an instance of Media
        if ($entity instanceof \Extranet\MediaBundle\Entity\AnnonceMedia) {
            // set annonce folder
            $entity->getMedia()->setUploadDir($this->container->getParameter('medias.repertoire.annonces'));
        }
        if ($entity instanceof \Extranet\MediaBundle\Entity\DocumentMedia) {
            // set document folder
            $entity->getMedia()->setUploadDir($this->container->getParameter('medias.repertoire.documents'));
        }
    }

    /**
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     *
     * Set upload folder for each media
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        // get request entity
        $entity = $args->getEntity();

        // check if it's an instance of Media
        if ($entity instanceof \Extranet\MediaBundle\Entity\AnnonceMedia) {
            // set annonce folder
            $entity->getMedia()->setUploadDir($this->container->getParameter('medias.repertoire.annonces'));
        }
        if ($entity instanceof \Extranet\MediaBundle\Entity\DocumentMedia) {
            // set document folder
            $entity->getMedia()->setUploadDir($this->container->getParameter('medias.repertoire.documents'));
        }
    }
}
