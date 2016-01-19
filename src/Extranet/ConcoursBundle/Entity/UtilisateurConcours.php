<?php

namespace Extranet\ConcoursBundle\Entity;

/**
 * UtilisateurConcours
 */
class UtilisateurConcours
{
    /**
     * @var boolean
     */
    private $repondu;

    /**
     * @var \Extranet\ConcoursBundle\Entity\Reponse
     */
    private $idreponse;

    /**
     * @var \Extranet\ConcoursBundle\Entity\Concours
     */
    private $idconcours;

    /**
     * @var \Extranet\UtilisateurBundle\Entity\Utilisateur
     */
    private $idutilisateur;


    /**
     * Set repondu
     *
     * @param boolean $repondu
     *
     * @return UtilisateurConcours
     */
    public function setRepondu($repondu)
    {
        $this->repondu = $repondu;

        return $this;
    }

    /**
     * Get repondu
     *
     * @return boolean
     */
    public function getRepondu()
    {
        return $this->repondu;
    }

    /**
     * Set idreponse
     *
     * @param \Extranet\ConcoursBundle\Entity\Reponse $idreponse
     *
     * @return UtilisateurConcours
     */
    public function setIdreponse(\Extranet\ConcoursBundle\Entity\Reponse $idreponse)
    {
        $this->idreponse = $idreponse;

        return $this;
    }

    /**
     * Get idreponse
     *
     * @return \Extranet\ConcoursBundle\Entity\Reponse
     */
    public function getIdreponse()
    {
        return $this->idreponse;
    }

    /**
     * Set idconcours
     *
     * @param \Extranet\ConcoursBundle\Entity\Concours $idconcours
     *
     * @return UtilisateurConcours
     */
    public function setIdconcours(\Extranet\ConcoursBundle\Entity\Concours $idconcours)
    {
        $this->idconcours = $idconcours;

        return $this;
    }

    /**
     * Get idconcours
     *
     * @return \Extranet\ConcoursBundle\Entity\Concours
     */
    public function getIdconcours()
    {
        return $this->idconcours;
    }

    /**
     * Set idutilisateur
     *
     * @param \Extranet\UtilisateurBundle\Entity\Utilisateur $idutilisateur
     *
     * @return UtilisateurConcours
     */
    public function setIdutilisateur(\Extranet\UtilisateurBundle\Entity\Utilisateur $idutilisateur)
    {
        $this->idutilisateur = $idutilisateur;

        return $this;
    }

    /**
     * Get idutilisateur
     *
     * @return \Extranet\UtilisateurBundle\Entity\Utilisateur
     */
    public function getIdutilisateur()
    {
        return $this->idutilisateur;
    }
}

