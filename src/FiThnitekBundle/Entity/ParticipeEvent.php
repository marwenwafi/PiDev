<?php

namespace FiThnitekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParticipeEvent
 *
 * @ORM\Table(name="participe_event")
 * @ORM\Entity(repositoryClass="FiThnitekBundle\Repository\ParticipeEventRepository")
 */
class ParticipeEvent
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

     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="userId",
     *  referencedColumnName="id")
     */
    private $userid;

    /**

     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="eventId",
     *  referencedColumnName="id")
     */
    private $eventid;

    /**
     * @var bool
     *
     * @ORM\Column(name="participe", type="boolean",nullable=true
     *     )
     */
    private $participe;

    /**
     * ParticipeEvent constructor.
     * @param $userid
     * @param $eventid
     * @param bool $participe
     */


    public function __construct($userid, $eventid)
    {
        $this->userid = $userid;
        $this->eventid = $eventid;
        $this->participe = true;
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
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return mixed
     */
    public function getEventid()
    {
        return $this->eventid;
    }

    /**
     * @param mixed $eventid
     */
    public function setEventid($eventid)
    {
        $this->eventid = $eventid;
    }

    /**
     * @return bool
     */
    public function isParticipe()
    {
        return $this->participe;
    }

    /**
     * @param bool $participe
     */
    public function setParticipe($participe)
    {
        $this->participe = $participe;
    }


}

