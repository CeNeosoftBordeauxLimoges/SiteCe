<?php

namespace Extranet\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="Medias")
 * @ORM\Entity(repositoryClass="Extranet\MediaBundle\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Media
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     *
     * @Assert\File(maxSize="2M")
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    private $uploadDir;

    private $temp;

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return  $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir()
    {

        return __DIR__.'/../../../../web/medias/cache/document_small/'.$this->getUploadDir();
    }

    public function setUploadDir($uploadDir) {
        $this->uploadDir = $uploadDir;

        return $this;
    }

    public function getUploadDir()
    {
        return $this->uploadDir;
    }

    /**
     * Sets file.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old file path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
//        if (null !== $this->getFile()) {
//            // do whatever you want to generate a unique name
//            $filename   = sha1(uniqid(mt_rand(), true));
//            $this->path = $filename.'.'.$this->getFile()->guessExtension();
//        }
        if (null !== $this->file) {
            // faites ce que vous voulez pour générer un nom unique
            $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

//        // check if we have an old image
//        if (isset($this->temp)) {
//            // delete the old image
//            unlink($this->getUploadRootDir().'/'.$this->temp);
//            // clear the temp image path
//            $this->temp = null;
//        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }

    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set path
     *
     * @param  string  $path
     * @return Media
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
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
}
