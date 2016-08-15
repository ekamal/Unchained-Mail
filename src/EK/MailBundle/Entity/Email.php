<?php

namespace EK\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Email
 *
 * @ORM\Table(name="email")
 * @ORM\Entity(repositoryClass="EK\MailBundle\Repository\EmailRepository")
 */
class Email
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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="Data", inversedBy="emails")
     * @ORM\JoinColumn(name="data_id", referencedColumnName="id")
     */
    private $data;

    /**
     * @ORM\OneToMany(targetEntity="Track", mappedBy="email")
     */
    protected $tracks;

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
     * Set email
     *
     * @param string $email
     * @return Email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set data
     *
     * @param \EK\MailBundle\Entity\Data $data
     * @return Email
     */
    public function setData(\EK\MailBundle\Entity\Data $data = null)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \EK\MailBundle\Entity\Data 
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tracks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tracks
     *
     * @param \EK\MailBundle\Entity\Track $tracks
     * @return Email
     */
    public function addTrack(\EK\MailBundle\Entity\Track $tracks)
    {
        $this->tracks[] = $tracks;

        return $this;
    }

    /**
     * Remove tracks
     *
     * @param \EK\MailBundle\Entity\Track $tracks
     */
    public function removeTrack(\EK\MailBundle\Entity\Track $tracks)
    {
        $this->tracks->removeElement($tracks);
    }

    /**
     * Get tracks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTracks()
    {
        return $this->tracks;
    }
}
