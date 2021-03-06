<?php

namespace EK\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Campagne
 *
 * @ORM\Table(name="campagne")
 * @ORM\Entity(repositoryClass="EK\MailBundle\Repository\CampagneRepository")
 */
class Campagne
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
     * @ORM\Column(name="nomCampagne", type="string", length=255)
     */
    private $nomCampagne;

    /**
     * @var bool
     *
     * @ORM\Column(name="tracking", type="boolean")
     */
    private $tracking;

    /**
     * @var bool
     *
     * @ORM\Column(name="pause", type="boolean")
     */
    private $pause;

    /**
     * @var string
     *
     * @ORM\Column(name="emailTest", type="string", length=255)
     */
    private $emailTest;

    /**
     * @var string
     *
     * @ORM\Column(name="header", type="text")
     */
    private $header;

    /**
     * @var int
     *
     * @ORM\Column(name="encoding", type="integer")
     */
    private $encoding;

    /**
     * @var int
     *
     * @ORM\Column(name="typeContent", type="integer")
     */
    private $typeContent;

    /**
     * @var int
     *
     * @ORM\Column(name="charset", type="integer")
     */
    private $charset;

    /**
     * @var string
     *
     * @ORM\Column(name="html", type="text")
     */
    private $html;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="numSent", type="integer")
     */
    private $numSent;

    /**
     * @var int
     *
     * @ORM\Column(name="numNoSent", type="integer")
     */
    private $numNoSent;

    /**
     * @var int
     *
     * @ORM\Column(name="clicks", type="integer")
     */
    private $clicks;

    /**
     * @var int
     *
     * @ORM\Column(name="opens", type="integer")
     */
    private $opens;

    /**
     * @var int
     *
     * @ORM\Column(name="unsubs", type="integer")
     */
    private $unsubs;

    /**
     * @var int
     *
     * @ORM\Column(name="limite", type="integer")
     */
    private $limite;

    /**
     * @var int
     *
     * @ORM\Column(name="waiting", type="integer")
     */
    private $waiting;

    /**
     * @var int
     *
     * @ORM\Column(name="feedback", type="integer")
     */
    private $feedback;

    /**
     * @ORM\ManyToMany(targetEntity="Data", cascade={"persist"})
     */
    private $datas;

    /**
     * @ORM\ManyToOne(targetEntity="Offre", inversedBy="campagnes")
     * @ORM\JoinColumn(name="offre_id", referencedColumnName="id")
     */
    private $offre;

    /**
     * @ORM\ManyToOne(targetEntity="Domaine", inversedBy="campagnes")
     * @ORM\JoinColumn(name="domaine_id", referencedColumnName="id")
     */
    private $domaine;

    /**
     * @ORM\ManyToMany(targetEntity="Ip", cascade={"persist"})
     */
    private $ips;

    /**
     * @ORM\OneToMany(targetEntity="Track", mappedBy="campagne")
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
     * Set nomCampagne
     *
     * @param string $nomCampagne
     * @return Campagne
     */
    public function setNomCampagne($nomCampagne)
    {
        $this->nomCampagne = $nomCampagne;

        return $this;
    }

    /**
     * Get nomCampagne
     *
     * @return string 
     */
    public function getNomCampagne()
    {
        return $this->nomCampagne;
    }

    /**
     * Set header
     *
     * @param string $header
     * @return Campagne
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return string 
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set html
     *
     * @param string $html
     * @return Campagne
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get html
     *
     * @return string 
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Campagne
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set numSent
     *
     * @param integer $numSent
     * @return Campagne
     */
    public function setNumSent($numSent)
    {
        $this->numSent = $numSent;

        return $this;
    }

    /**
     * Get numSent
     *
     * @return integer 
     */
    public function getNumSent()
    {
        return $this->numSent;
    }

    /**
     * Set numNoSent
     *
     * @param integer $numNoSent
     * @return Campagne
     */
    public function setNumNoSent($numNoSent)
    {
        $this->numNoSent = $numNoSent;

        return $this;
    }

    /**
     * Get numNoSent
     *
     * @return integer 
     */
    public function getNumNoSent()
    {
        return $this->numNoSent;
    }



    /**
     * Set offre
     *
     * @param \EK\MailBundle\Entity\Offre $offre
     * @return Campagne
     */
    public function setOffre(\EK\MailBundle\Entity\Offre $offre = null)
    {
        $this->offre = $offre;

        return $this;
    }

    /**
     * Get offre
     *
     * @return \EK\MailBundle\Entity\Offre 
     */
    public function getOffre()
    {
        return $this->offre;
    }

    /**
     * Set domaine
     *
     * @param \EK\MailBundle\Entity\Domaine $domaine
     * @return Campagne
     */
    public function setDomaine(\EK\MailBundle\Entity\Domaine $domaine = null)
    {
        $this->domaine = $domaine;

        return $this;
    }

    /**
     * Get domaine
     *
     * @return \EK\MailBundle\Entity\Domaine 
     */
    public function getDomaine()
    {
        return $this->domaine;
    }

    /**
     * Set clicks
     *
     * @param integer $clicks
     * @return Campagne
     */
    public function setClicks($clicks)
    {
        $this->clicks = $clicks;

        return $this;
    }

    /**
     * Get clicks
     *
     * @return integer 
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * Set opens
     *
     * @param integer $opens
     * @return Campagne
     */
    public function setOpens($opens)
    {
        $this->opens = $opens;

        return $this;
    }

    /**
     * Get opens
     *
     * @return integer 
     */
    public function getOpens()
    {
        return $this->opens;
    }

    /**
     * Set unsubs
     *
     * @param integer $unsubs
     * @return Campagne
     */
    public function setUnsubs($unsubs)
    {
        $this->unsubs = $unsubs;

        return $this;
    }

    /**
     * Get unsubs
     *
     * @return integer 
     */
    public function getUnsubs()
    {
        return $this->unsubs;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ips = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ips
     *
     * @param \EK\MailBundle\Entity\Ip $ips
     * @return Campagne
     */
    public function addIp(\EK\MailBundle\Entity\Ip $ips)
    {
        $this->ips[] = $ips;

        return $this;
    }

    /**
     * Remove ips
     *
     * @param \EK\MailBundle\Entity\Ip $ips
     */
    public function removeIp(\EK\MailBundle\Entity\Ip $ips)
    {
        $this->ips->removeElement($ips);
    }

    /**
     * Get ips
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIps()
    {
        return $this->ips;
    }

    /**
     * Add tracks
     *
     * @param \EK\MailBundle\Entity\Track $tracks
     * @return Campagne
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

    /**
     * Add datas
     *
     * @param \EK\MailBundle\Entity\Data $datas
     * @return Campagne
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
     * Set emailTest
     *
     * @param string $emailTest
     * @return Campagne
     */
    public function setEmailTest($emailTest)
    {
        $this->emailTest = $emailTest;

        return $this;
    }

    /**
     * Get emailTest
     *
     * @return string 
     */
    public function getEmailTest()
    {
        return $this->emailTest;
    }

    /**
     * Set tracking
     *
     * @param boolean $tracking
     * @return Campagne
     */
    public function setTracking($tracking)
    {
        $this->tracking = $tracking;

        return $this;
    }

    /**
     * Get tracking
     *
     * @return boolean 
     */
    public function getTracking()
    {
        return $this->tracking;
    }

    /**
     * Set encoding
     *
     * @param integer $encoding
     *
     * @return Campagne
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;

        return $this;
    }

    /**
     * Get encoding
     *
     * @return integer
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Set typeContent
     *
     * @param integer $typeContent
     *
     * @return Campagne
     */
    public function setTypeContent($typeContent)
    {
        $this->typeContent = $typeContent;

        return $this;
    }

    /**
     * Get typeContent
     *
     * @return integer
     */
    public function getTypeContent()
    {
        return $this->typeContent;
    }

    /**
     * Set charset
     *
     * @param integer $charset
     *
     * @return Campagne
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * Get charset
     *
     * @return integer
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Set pause
     *
     * @param boolean $pause
     *
     * @return Campagne
     */
    public function setPause($pause)
    {
        $this->pause = $pause;

        return $this;
    }

    /**
     * Get pause
     *
     * @return boolean
     */
    public function getPause()
    {
        return $this->pause;
    }

    /**
     * Set limite
     *
     * @param integer $limite
     *
     * @return Campagne
     */
    public function setLimite($limite)
    {
        $this->limite = $limite;

        return $this;
    }

    /**
     * Get limite
     *
     * @return integer
     */
    public function getLimite()
    {
        return $this->limite;
    }

    /**
     * Set waiting
     *
     * @param integer $waiting
     *
     * @return Campagne
     */
    public function setWaiting($waiting)
    {
        $this->waiting = $waiting;

        return $this;
    }

    /**
     * Get waiting
     *
     * @return integer
     */
    public function getWaiting()
    {
        return $this->waiting;
    }

    /**
     * Set feedback
     *
     * @param integer $feedback
     *
     * @return Campagne
     */
    public function setFeedback($feedback)
    {
        $this->feedback = $feedback;

        return $this;
    }

    /**
     * Get feedback
     *
     * @return integer
     */
    public function getFeedback()
    {
        return $this->feedback;
    }
}
