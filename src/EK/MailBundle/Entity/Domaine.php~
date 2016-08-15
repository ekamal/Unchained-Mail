<?php

namespace EK\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Domaine
 *
 * @ORM\Table(name="domaine")
 * @ORM\Entity(repositoryClass="EK\MailBundle\Repository\DomaineRepository")
 */
class Domaine
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
     * @ORM\Column(name="domaine", type="string", length=255)
     */
    private $domaine;

    /**
     * @var bool
     *
     * @ORM\Column(name="etat", type="boolean")
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity="Campagne", mappedBy="domaine")
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
     * Set domaine
     *
     * @param string $domaine
     * @return Domaine
     */
    public function setDomaine($domaine)
    {
        $this->domaine = $domaine;

        return $this;
    }

    /**
     * Get domaine
     *
     * @return string 
     */
    public function getDomaine()
    {
        return $this->domaine;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     * @return Domaine
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
     * @return Domaine
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
