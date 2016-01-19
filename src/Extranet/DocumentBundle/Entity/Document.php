<?php

namespace Extranet\DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
//use Extranet\MediaBundle\Validator\Constraints as Assert;

/**
 * Document
 *
 * @ORM\Table(name="Document")
 * @ORM\Entity(repositoryClass="Extranet\DocumentBundle\Repository\DocumentRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Document
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="medias",type="blob")
     */
    private $medias;

    /**
     * @ORM\Column(name="nom",type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(name="extension",type="string", length=255)
     */
    private $extension;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="Extranet\UtilisateurBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")
     */
    private $utilisateur;

    private $uploadDir;

    private $temp;

    private $file;

    private $extensionType = array(
                                    'doc'   => 'application/msword',
                                    'pdf'   => 'application/pdf',
                                    'ps'    => 'application/postscript',
                                    'rtf'   => 'application/rtf',
                                    'bz2'   => 'application/x-bzip',
                                    'tbz2'  => 'application/x-bzip',
                                    'gz'    => 'application/x-gzip',
                                    'tgz'   => 'application/x-gzip',
                                    'xhtml' => 'application/xhtml+xml',
                                    'zip'   => 'application/zip',
                                    'xls'   => 'application/vnd.ms-excel',
                                    'ppt'   => 'application/vnd.ms-powerpoint',
                                    'odp'   => 'application/vnd.oasis.opendocument.presentation',
                                    'ods'   => 'application/vnd.oasis.opendocument.spreadsheet',
                                    'odt'   => 'application/vnd.oasis.opendocument.text',
                                    'pptx'  => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                    'xlsx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                    'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                    'gif'   => 'image/gif',
                                    'jpeg'  => 'image/jpeg',
                                    'jpg'   => 'image/jpeg',
                                    'png'   => 'image/png',
                                    'csv'   => 'text/csv',
                                    'htm'   => 'text/html',
                                    'html'  => 'text/html',
                                    'txt'   => 'text/plain',
                                    'xml'   => 'text/xml',
                                    );

    public function __construct()
    {
        $this->active = false;
        //$this->medias = new \Doctrine\Common\Collections\ArrayCollection();
    }
/*
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
        //return  $this->getUploadDir() . '/' . $this->path;
    }
*/
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

  /*  public function setUploadDir($uploadDir)
    {
        $this->uploadDir = $uploadDir;

        return $this;
    }
  */

    public function getUploadDir()
    {
        //return $this->uploadDir;
        return 'uploads/documents';
    }

  /*  /**
     * Sets file.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    /*public function setFile(\Symfony\Component\HttpFoundation\File\UploadedFile  $file = null)
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
    }*/

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $this->nom = $this->file->getClientOriginalName();
            $this->extension = $this->file->getClientOriginalExtension();
            $tmp =  $this->file->openFile();
            $this->medias = $tmp->fread($tmp->getSize());
        }
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        if(! is_null($file)){
            $this->setNom(null);
            $this->setmedias(null);
        }
        $this->file = $file;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
       // if (null === $this->medias) {
      //      return;
      //  }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
       // $this->medias = $this->file;
       // $this->medias->move($this->getUploadRootDir(), $this->path);


        //$this->medias = null;
        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getfile()) {
            unlink($file);
        }
    }
/*
    /**
     * Get path
     *
     * @return string
     */
 /*   public function getPath()
    {
        return $this->path;
    }
/*
    /**
     * Set path
     *
     * @param  string  $path
     * @return Document
     */
  /*  public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
*/
    public static function initDocument($utilisateur)
    {
        $document= new document();

        $document->setUtilisateur($utilisateur);
        $document->setActive(true);

        return $document;
    }

    /**
     * set medias
     *
     * @param string $medias
     * @return Document
     */

    public function setMedias($medias)
    {
       $this->medias=$medias;

        return $this;
    }

    /**
     * Get medias
     *
     * @return string
     */

    public function getMedias()
    {
        return $this->medias;
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
     * Set titre
     *
     * @param string $titre
     * @return Document
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Document
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Document
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Document
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set utilisateur
     *
     * @param Extranet\UtilisateurBundle\Entity\Utilisateur $utilisateur
     * @return Document
     */
    public function setUtilisateur(\Extranet\UtilisateurBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return UtilisateurExtranet\UtilisateurBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    public function getContentType(){

        if (array_key_exists(strtolower($this->extension), $this->extensionType)) {
            return  $this->extensionType[strtolower($this->extension)];
        }

        return 'application/octet-stream';
    }


    public function getMediasContent(){
        if ('resource' == gettype($this->medias)) {
            return stream_get_contents($this->medias);
        }

        return $this->medias;

    }
}
