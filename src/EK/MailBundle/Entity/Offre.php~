<?php

namespace EK\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Offre
 *
 * @ORM\Table(name="offre")
 * @ORM\Entity(repositoryClass="EK\MailBundle\Repository\OffreRepository")
 */
class Offre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomOffre", type="string", length=255)
     */
    private $nomOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="lien", type="string", length=255)
     */
    private $lien;

    /**
     * @var string
     *
     * @ORM\Column(name="creative", type="string", length=255)
     */
    private $creative;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="etat", type="boolean")
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity="Campagne", mappedBy="offre")
     */
    protected $campagnes;

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
     * Set nomOffre
     *
     * @param string $nomOffre
     * @return Offre
     */
    public function setNomOffre($nomOffre)
    {
        $this->nomOffre = $nomOffre;

        return $this;
    }

    /**
     * Get nomOffre
     *
     * @return string 
     */
    public function getNomOffre()
    {
        return $this->nomOffre;
    }

    /**
     * Set lien
     *
     * @param string $lien
     * @return Offre
     */
    public function setLien($lien)
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * Get lien
     *
     * @return string 
     */
    public function getLien()
    {
        return $this->lien;
    }

    /**
     * Set creative
     *
     * @param string $creative
     * @return Offre
     */
    public function setCreative($creative)
    {
        $this->creative = $creative;

        return $this;
    }

    /**
     * Get creative
     *
     * @return string 
     */
    public function getCreative()
    {
        return $this->creative;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Offre
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
     * Set etat
     *
     * @param boolean $etat
     * @return Offre
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean 
     */
    public function getEtat()
    {
        return $this->etat;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->campagnes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add campagnes
     *
     * @param \EK\MailBundle\Entity\Campagne $campagnes
     * @return Offre
     */
    public function addCampagne(\EK\MailBundle\Entity\Campagne $campagnes)
    {
        $this->campagnes[] = $campagnes;

        return $this;
    }

    /**
     * Remove campagnes
     *
     * @param \EK\MailBundle\Entity\Campagne $campagnes
     */
    public function removeCampagne(\EK\MailBundle\Entity\Campagne $campagnes)
    {
        $this->campagnes->removeElement($campagnes);
    }

    /**
     * Get campagnes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCampagnes()
    {
        return $this->campagnes;
    }
}
