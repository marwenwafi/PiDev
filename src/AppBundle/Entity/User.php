<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string",length=255)
     */

    protected $prenom ;

    /**
     * @ORM\Column(type="integer")
     */

    protected $tel ;
    /**
     * @ORM\Column(type="string",length=255)
     */

    protected $image ;

    /**
     * @ORM\Column(type="date")
     */
    protected $datedenaissance;

    /**
     * @ORM\Column(type="date")
     */
    protected $registrationdate;

    /**
     * @ORM\Column(type="integer")
     */
    protected $nbroffre=0 ;

    /**
     * @ORM\Column(type="integer")
     */
    protected $points = 0 ;

    public function __construct()
    {
        parent::__construct();
        $this->registrationdate = new \DateTime();
    }

    /**
     * @return string|null
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param string|null $confirmationToken
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * @return mixed
     */
    public function getDatedenaissance()
    {
        return $this->datedenaissance;
    }

    /**
     * @param mixed $datedenaissance
     */
    public function setDatedenaissance($datedenaissance)
    {
        $this->datedenaissance = $datedenaissance;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getNbroffre()
    {
        return $this->nbroffre;
    }

    /**
     * @param mixed $nbroffre
     */
    public function setNbroffre($nbroffre)
    {
        $this->nbroffre = $nbroffre;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param mixed $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * @return \DateTime
     */
    public function getRegistrationdate()
    {
        return $this->registrationdate;
    }

    /**
     * @param \DateTime $registrationdate
     */
    public function setRegistrationdate($registrationdate)
    {
        $this->registrationdate = $registrationdate;
    }


}
