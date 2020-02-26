<?php

namespace FiThnitekBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="FiThnitekBundle\Repository\EventRepository")

 */
class Event
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
     * @ORM\Column(name="titre", type="string", length=255,unique=true)
     *  @Assert\NotBlank(message="Le champ titre est obligatoire")
     * @Assert\Length(min=3,max=20)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="date")
     *
     * @Assert\GreaterThanOrEqual("today")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date")
     * @Assert\GreaterThanOrEqual("today")
     * @Assert\Expression(
     *     "this.getDateDebut() <= this.getDateFin()",
     *     message="La date fin ne doit pas être inférieur à la date début"
     * )
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\NotBlank(message="Le champ description est obligatoire")
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="promotion", type="integer")
     * @Assert\NotBlank(message="Le champ promotion est obligatoire")
     * @Assert\GreaterThanOrEqual("1")
     */
    private $promotion;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     *  @Assert\Url(
     *     protocols = {"http"}
     *     )
     *
     */
    private $url;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     * @Assert\NotBlank(message="Le champ image est obligatoire")
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="operation", type="string", length=255, nullable=true)
     *
     */

    private $operation;


    /***************************************************/
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="iduser"),
     * ReferencedColumnName="id")
     */
    private $user;


    /********************************************************




    /**

     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinTable(name="participer",
     *     joinColumns={@ORM\JoinColumn(name="eventId" ,
     *     referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="userId" ,
     *     referencedColumnName="id")}
     *     )
     *
     */
    private $participants;
    /***************************************************/
    /*******************************************************/
    /**

     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinTable(name="destinataires",
     *     joinColumns={@ORM\JoinColumn(name="eventId" ,
     *     referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="userId" ,
     *     referencedColumnName="id")}
     *     )
     *
     */
    private $destinataires;

    /**
     * @return ArrayCollection
     */
    public function getDestinataires()
    {
        return $this->destinataires;
    }

    /**
     * @param ArrayCollection $destinataires
     */
    public function setDestinataires($destinataires)
    {
        $this->destinataires = $destinataires;
    }



    /**
     * Event constructor.
     */
    public function __construct()
    {
        $this->dateDebut = new \Datetime();
        $this->dateFin = new \Datetime();

    }


    /**
     * @return ArrayCollection
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param ArrayCollection $participants
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;

    }
    /**
     * Get id
     *
     * @return int
     */


    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Event
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Event
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @return mixed
     */
    public function getAdmins()
    {
        return $this->admins;
    }

    /**
     * @param mixed $admins
     */
    public function setAdmins($admins)
    {
        $this->admins = $admins;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
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
     * Set promotion
     *
     * @param integer $promotion
     *
     * @return Event
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * Get promotion
     *
     * @return int
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Event
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }


    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }


    public function getImage()
    {
        return $this->image;
    }


    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @param string $operation
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
    }
    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }
















}

