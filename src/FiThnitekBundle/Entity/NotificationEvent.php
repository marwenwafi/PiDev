<?php

namespace FiThnitekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Model\BaseNotification;

/**
 * NotificationEvent
 *
 * @ORM\Table(name="notification_event")
 * @ORM\Entity(repositoryClass="FiThnitekBundle\Repository\NotificationEventRepository")
 */
class NotificationEvent extends BaseNotification implements \JsonSerializable
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
     * @var int
     *
     * @ORM\Column(name="idevent", type="integer",unique=true)
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

    public function __construct()
    {
        parent::__construct();
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



    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

