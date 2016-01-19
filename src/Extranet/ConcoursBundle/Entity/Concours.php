<?php

namespace Extranet\ConcoursBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table(name="Concours")
 * @ORM\Entity(repositoryClass="Extranet\ConcoursBundle\Repository\ConcoursRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Concours
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="idconcours", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $idconcours;
	
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
     * @var \DateTime
     * 
     * @ORM\Column(name="datelimite", type="datetime")
     */
    private $datelimite;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="datecreation", type="datetime")
     */
    private $datecreation;

    /**
     * Get idconcours
     *
     * @return integer
     */
    public function getIdconcours()
    {
    	return $this->idconcours;
    }
    
    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Concours
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
     *
     * @return Concours
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
     * Set datelimite
     *
     * @param \DateTime $datelimite
     *
     * @return Concours
     */
    public function setDatelimite($datelimite)
    {
        $this->datelimite = $datelimite;

        return $this;
    }

    /**
     * Get datelimite
     *
     * @return \DateTime
     */
    public function getDatelimite()
    {
        return $this->datelimite;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Concours
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }
}

