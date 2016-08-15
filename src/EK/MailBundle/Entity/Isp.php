<?php

namespace EK\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Isp
 *
 * @ORM\Table(name="isp")
 * @ORM\Entity(repositoryClass="EK\MailBundle\Repository\IspRepository")
 */
class Isp
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
     * @ORM\Column(name="isp", type="string", length=255)
     */
    private $isp;

    /**
     * @ORM\OneToMany(targetEntity="Data", mappedBy="isp")
     */
    protected $datas;

    /**
     * @ORM\OneToMany(targetEntity="Bounce", mappedBy="isp")
     */
    protected $bounces;

    /**
     * @ORM\OneToMany(targetEntity="Unsub", mappedBy="isp")
     */
    protected $unsubs;

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
     * Set isp
     *
     * @param string $isp
     * @return Isp
     */
    public function setIsp($isp)
    {
        $this->isp = $isp;

        return $this;
    }

    /**
     * Get isp
     *
     * @return string 
     */
    public function getIsp()
    {
        return $this->isp;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bounces = new \Doctrine\Common\Collections\ArrayCollection();
        $this->unsubs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add datas
     *
     * @param \EK\MailBundle\Entity\Data $datas
     * @return Isp
     */
    public function addData(\EK\MailBundle\Entity\Data $datas)
    {
        $this->datas[] = $datas;

        return $this;
    }

    /**
     * Remove datas
     *
     * @param \EK\MailBundle\Entity\Data $datas
     */
    public function removeData(\EK\MailBundle\Entity\Data $datas)
    {
        $this->datas->removeElement($datas);
    }

    /**
     * Get datas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDatas()
    {
        return $this->datas;
    }

    /**
     * Add bounces
     *
     * @param \EK\MailBundle\Entity\Bounce $bounces
     * @return Isp
     */
    public function addBounce(\EK\MailBundle\Entity\Bounce $bounces)
    {
        $this->bounces[] = $bounces;

        return $this;
    }

    /**
     * Remove bounces
     *
     * @param \EK\MailBundle\Entity\Bounce $bounces
     */
    public function removeBounce(\EK\MailBundle\Entity\Bounce $bounces)
    {
        $this->bounces->removeElement($bounces);
    }

    /**
     * Get bounces
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBounces()
    {
        return $this->bounces;
    }

    /**
     * Add unsubs
     *
     * @param \EK\MailBundle\Entity\Unsub $unsubs
     * @return Isp
     */
    public function addUnsub(\EK\MailBundle\Entity\Unsub $unsubs)
    {
        $this->unsubs[] = $unsubs;

        return $this;
    }

    /**
     * Remove unsubs
     *
     * @param \EK\MailBundle\Entity\Unsub $unsubs
     */
    public function removeUnsub(\EK\MailBundle\Entity\Unsub $unsubs)
    {
        $this->unsubs->removeElement($unsubs);
    }

    /**
     * Get unsubs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnsubs()
    {
        return $this->unsubs;
    }
}
