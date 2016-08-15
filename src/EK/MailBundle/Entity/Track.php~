<?php

namespace EK\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Track
 *
 * @ORM\Table(name="track")
 * @ORM\Entity(repositoryClass="EK\MailBundle\Repository\TrackRepository")
 */
class Track
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
     * @var bool
     *
     * @ORM\Column(name="click", type="boolean")
     */
    private $click;

    /**
     * @var bool
     *
     * @ORM\Column(name="open", type="boolean")
     */
    private $open;

    /**
     * @var bool
     *
     * @ORM\Column(name="unsub", type="boolean")
     */
    private $unsub;

    /**
     * @ORM\ManyToOne(targetEntity="Email", inversedBy="tracks")
     * @ORM\JoinColumn(name="email_id", referencedColumnName="id")
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="Campagne", inversedBy="tracks")
     * @ORM\JoinColumn(name="campagne_id", referencedColumnName="id")
     */
    private $campagne;

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
     * Set click
     *
     * @param boolean $click
     * @return Track
     */
    public function setClick($click)
    {
        $this->click = $click;

        return $this;
    }

    /**
     * Get click
     *
     * @return boolean 
     */
    public function getClick()
    {
        return $this->click;
    }

    /**
     * Set open
     *
     * @param boolean $open
     * @return Track
     */
    public function setOpen($open)
    {
        $this->open = $open;

        return $this;
    }

    /**
     * Get open
     *
     * @return boolean 
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set unsub
     *
     * @param boolean $unsub
     * @return Track
     */
    public function setUnsub($unsub)
    {
        $this->unsub = $unsub;

        return $this;
    }

    /**
     * Get unsub
     *
     * @return boolean 
     */
    public function getUnsub()
    {
        return $this->unsub;
    }

    /**
     * Set email
     *
     * @param \EK\MailBundle\Entity\Email $email
     * @return Track
     */
    public function setEmail(\EK\MailBundle\Entity\Email $email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return \EK\MailBundle\Entity\Email 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set campagne
     *
     * @param \EK\MailBundle\Entity\Campagne $campagne
     * @return Track
     */
    public function setCampagne(\EK\MailBundle\Entity\Campagne $campagne = null)
    {
        $this->campagne = $campagne;

        return $this;
    }

    /**
     * Get campagne
     *
     * @return \EK\MailBundle\Entity\Campagne 
     */
    public function getCampagne()
    {
        return $this->campagne;
    }
}
