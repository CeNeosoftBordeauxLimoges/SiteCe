<?php

namespace Extranet\UtilisateurBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Groupe")
 */
class Groupe extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Extranet\UtilisateurBundle\Entity\Utilisateur", mappedBy="groups")
     */
    protected $utilisateurs;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
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
     * Add utilisateurs
     *
     * @param \Extranet\UtilisateurBundle\Entity\Utilisateur $utilisateurs
     * @return Groupe
     */
    public function addUtilisateur(\Extranet\UtilisateurBundle\Entity\Utilisateur $utilisateurs)
    {
        $this->utilisateurs[] = $utilisateurs;

        return $this;
    }

    /**
     * Remove utilisateurs
     *
     * @param \Extranet\UtilisateurBundle\Entity\Utilisateur $utilisateurs
     */
    public function removeUtilisateur(\Extranet\UtilisateurBundle\Entity\Utilisateur $utilisateurs)
    {
        $this->utilisateurs->removeElement($utilisateurs);
    }

    /**
     * Get utilisateurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUtilisateurs()
    {
        return $this->utilisateurs;
    }
}
