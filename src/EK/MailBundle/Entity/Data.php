<?php

namespace EK\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Data
 *
 * @ORM\Table(name="data")
 * @ORM\Entity(repositoryClass="EK\MailBundle\Repository\DataRepository")
 */
class Data
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
     * @ORM\Column(name="nomData", type="string", length=255)
     */
    private $nomData;

    /**
     * @ORM\OneToMany(targetEntity="Email", mappedBy="data" , cascade={"persist", "remove"})
     */
    protected $emails;


    /**
     * @ORM\ManyToOne(targetEntity="Isp", inversedBy="datas")
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
     * Set nomData
     *
     * @param string $nomData
     * @return Data
     */
    public function setNomData($nomData)
    {
        $this->nomData = $nomData;

        return $this;
    }

    /**
     * Get nomData
     *
     * @return string 
     */
    public function getNomData()
    {
        return $this->nomData;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add emails
     *
     * @param \EK\MailBundle\Entity\Email $emails
     * @return Data
     */
    public function addEmail(\EK\MailBundle\Entity\Email $emails)
    {
        $this->emails[] = $emails;

        return $this;
    }

    /**
     * Remove emails
     *
     * @param \EK\MailBundle\Entity\Email $emails
     */
    public function removeEmail(\EK\MailBundle\Entity\Email $emails)
    {
        $this->emails->removeElement($emails);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**


    /**
     * Set isp
     *
     * @param \EK\MailBundle\Entity\Isp $isp
     * @return Data
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
