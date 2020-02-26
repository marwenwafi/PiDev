<?php

namespace FiThnitekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Model\BaseNotification;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="FiThnitekBundle\Repository\NotificationRepository")
 */
class Notification extends BaseNotification implements \JsonSerializable
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\user")
     * @ORM\JoinColumn(name="iduser" ,nullable=true ,
     *     referencedColumnName="id")
     */
    private $iduser;

    /**
     *@ORM\ManyToOne(targetEntity="DemandeTaxi")
     * @ORM\JoinColumn(name="iddemande",nullable=true,
     *     referencedColumnName="id")
     */
    private $idarticle;
    /**
     *@ORM\Column(type="string",length=255, nullable=true)
     */
    private $type ;


    /**
     * @var int
     *
     * @ORM\Column(name="idevent", type="integer",unique=true,nullable=true)
     *
     */
    private $idevent;


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
     * @return int
     */
    public function getIdevent()
    {
        return $this->idevent;
    }

    /**
     * @param int $idevent
     */
    public function setIdevent($idevent)
    {
        $this->idevent = $idevent;
    }



    public function __construct()
    {
        parent::__construct();
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return mixed
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param mixed $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    /**
     * @return mixed
     */
    public function getIdarticle()
    {
        return $this->idarticle;
    }

    /**
     * @param mixed $idarticle
     */
    public function setIdarticle($idarticle)
    {
        $this->idarticle = $idarticle;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}

