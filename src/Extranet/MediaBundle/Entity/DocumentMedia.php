<?php

namespace Extranet\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Document_medias")
 */
class DocumentMedia
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Extranet\DocumentBundle\Entity\Document", inversedBy="medias")
     * @ORM\JoinColumn(name="document_id", referencedColumnName="id")
     */
    protected $document;

    /**
     * @ORM\OneToOne(targetEntity="Extranet\MediaBundle\Entity\Media", cascade={"all"})
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
    */
    private $media;

    /**
     * @var principale
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $principale;

    /**
     * Remove medias
     *
     * @param \Extranet\MediaBundle\Entity\Media $medias
     */
    public function removeMedia(\Extranet\MediaBundle\Entity\Media $media)
    {
        $this->media->removeElement($media);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set document
     *
     * @param \Extranet\DocumentBundle\Entity\Document $document
     * @return DocumentMedia
     */
    public function setDocument(\Extranet\DocumentBundle\Entity\Document $document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return \Extranet\DocumentBundle\Entity\Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set media
     *
     * @param \Extranet\MediaBundle\Entity\Media $media
     * @return DocumentMedia
     */
    public function setMedia(\Extranet\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Extranet\MediaeBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set principale
     *
     * @param boolean $principale
     * @return DocumentMedia
     */
    public function setPrincipale($principale)
    {
        $this->principale = $principale;

        return $this;
    }

    /**
     * Get principale
     *
     * @return boolean 
     */
    public function getPrincipale()
    {
        return $this->principale;
    }
}
