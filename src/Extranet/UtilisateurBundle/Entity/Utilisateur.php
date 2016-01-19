<?php

namespace Extranet\UtilisateurBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Extranet\UtilisateurBundle\Repository\UtilisateurRepository")
 * @ORM\Table(name="Utilisateur")
 */
class Utilisateur extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Extranet\UtilisateurBundle\Entity\Groupe", inversedBy="utilisateurs")
     * @ORM\JoinTable(name="Utilisateur_groupe",
     *      joinColumns={@ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="groupe_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @var string $nom
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    protected $nom;

    /**
     * @var string $prenom
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    protected $prenom;

    /**
     * @var datetime $dateNaissance
     *
     * @ORM\Column(name="date_naissance", type="datetime", nullable=true)
     */
    protected $dateNaissance;

    /**
     * @var string $adresse
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    protected $adresse;

    /**
     * @var string $codePostal
     *
     * @ORM\Column(name="code_postal", type="string", length=5, nullable=true)
     */
    protected $codePostal;

    /**
     * @var string $ville
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    protected $ville;

    /**
     * @var string $agence
     *
     * @ORM\Column(name="agence", type="string", length=255, nullable=true)
     */
    protected $agence;

    /**
     * @return string
     */
    public function getAgence()
    {
        return $this->agence;
    }

    /**
     * @param string $agence
     */
    public function setAgence($agence)
    {
        $this->agence = $agence;
    }

    /**
     * @var string $telPerso
     *
     * @ORM\Column(name="tel_perso", type="string", length=10, nullable=true)
     */
    protected $telPerso;

    /**
     * @var string $profil
     *
     * @ORM\Column(name="profil", type="string", length=255, nullable=true)
     */
    protected $profil;

    /**
     * @var string $nbEnfants
     *
     * @ORM\Column(name="nb_enfants", type="integer", nullable=true)
     */
    protected $nbEnfants;

    public function __construct()
    {
        parent::__construct();

        $this->groups = new ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     * @return Utilisateur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Utilisateur
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Utilisateur
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     * @return Utilisateur
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Utilisateur
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set telPerso
     *
     * @param string $telPerso
     * @return Utilisateur
     */
    public function setTelPerso($telPerso)
    {
        $this->telPerso = $telPerso;

        return $this;
    }

    /**
     * Get telPerso
     *
     * @return string
     */
    public function getTelPerso()
    {
        return $this->telPerso;
    }
    /**
     * Set nbEnfants
     *
     * @param string $nbEnfants
     * @return Utilisateur
     */
    public function setNbEnfants($nbEnfants)
    {
        $this->nbEnfants = $nbEnfants;

        return $this;
    }

    /**
     * Get nbEnfants
     *
     * @return string
     */
    public function getNbEnfants()
    {
        return $this->nbEnfants;
    }

    /**
     * Set profil
     *
     * @param string $profil
     * @return Utilisateur
     */
    public function setProfil($profil)
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * Get profil
     *
     * @return string
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * Add groups
     *
     * @param \FOS\UserBundle\Entity\Group $groups
     * @return Usuario
     */
    public function setGroups(\Extranet\UtilisateurBundle\Entity\Groupe  $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     *
     */
    public function __toString() {
        return $this->prenom . ' ' . $this->nom;
    }

}
