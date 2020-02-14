<?php

namespace FiThnitekBundle\Entity;

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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

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

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="date")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date")
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="promotion", type="integer")
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
     * @ORM\Column(name="image", type="string", length=255,nullable=true)
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     */
    private $image;
    /*****************************************************/
    /*********************************************************/
    /**
     * @var string
     *
     * @ORM\Column(name="destinataires", type="string", length=255, nullable=true)
     *
     */

    private $destinataires;

    /***************************************************/
    /********************************************************/
    /**

     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinTable(name="gerer",
     *     joinColumns={@ORM\JoinColumn(name="eventId" ,
     *     referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="userId" ,
     *     referencedColumnName="id")}
     *     )
     *
     */
    private $admins;


    /***************************************************/
    /*******************************************************/
    private $questionnaire;

    /***************************************************/
    /********************************************************/
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
     * Event constructor.
     */
    public function __construct()
    {
        $this->admins = new ArrayCollection();
        $this->questionnaires = new ArrayCollection();
        $this->participants = new ArrayCollection();
        $this->destinataires = new ArrayCollection();
    }

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

}

