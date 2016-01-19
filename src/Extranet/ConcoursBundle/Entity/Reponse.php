<?php

namespace Extranet\ConcoursBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 * 
 * @ORM\Entity(repositoryClass="Extranet\ConcoursBundle\Repository\ReponseRepository")
 */
class Reponse
{
	/**
	 * @var integer
	 * 
	 * @ORM\Column(name="idreponse", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $idreponse;
	
    /**
     * @var string
     * 
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var boolean
     * 
     * @ORM\Column(name="reponsecorrecte", type="boolean")
     */
    private $reponsecorrecte;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Extranet\ConcoursBundle\Entity\Concours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $concours;
    
    /**
     * Get idreponse
     *
     * @return integer
     */
    public function getIdreponse()
    {
    	return $this->idreponse;
    }
    
    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Reponse
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set reponsecorrecte
     *
     * @param boolean $reponsecorrecte
     *
     * @return Reponse
     */
    public function setReponsecorrecte($reponsecorrecte)
    {
        $this->reponsecorrecte = $reponsecorrecte;

        return $this;
    }

    /**
     * Get reponsecorrecte
     *
     * @return boolean
     */
    public function getReponsecorrecte()
    {
        return $this->reponsecorrecte;
    }
    
    public function setConcours(Concours $concours) {
    	$this->concours = $concours;
    	 
    	return $this;
    }
    
    public function getConcours() {
    	return $this->concours;
    }
}

