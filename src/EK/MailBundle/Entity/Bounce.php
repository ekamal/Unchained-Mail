<?php

namespace EK\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bounce
 *
 * @ORM\Table(name="bounce")
 * @ORM\Entity(repositoryClass="EK\MailBundle\Repository\BounceRepository")
 */
class Bounce
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
     * @ORM\ManyToOne(targetEntity="Isp", inversedBy="bounces")
     * @ORM\JoinColumn(name="isp_id", referencedColumnName="id")
     */
    private $isp;

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
     * @return Bounce
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
     * Set isp
     *
     * @param \EK\MailBundle\Entity\Isp $isp
     * @return Bounce
     */
    public function setIsp(\EK\MailBundle\Entity\Isp $isp = null)
    {
        $this->isp = $isp;

        return $this;
    }

    /**
     * Get isp
     *
     * @return \EK\MailBundle\Entity\Isp 
     */
    public function getIsp()
    {
        return $this->isp;
    }
}
