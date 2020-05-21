<?php
// src/AppBundle/Entity/User.php

namespace FiThnitekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity (repositoryClass="FiThnitekBundle\Repository\ObjectifRepository")
 */
class Objectif
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idObjectif;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     * * @Assert\GreaterThan(0)
     */
    private $but;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;


    /**
     * @ORM\Column(type="date")
     */
    private $start_date;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="start_date")
     */
    private $end_date;


    /**
     * Objectif constructor.
     */
    public function __construct()
    {
        $this->start_date = new \DateTime();
        $this->end_date = new \DateTime();
        $this->etat=false;
    }

    /**
     * @return mixed
     */
    public function getIdObjectif()
    {
        return $this->idObjectif;
    }

    /**
     * @param mixed $idObjectif
     */
    public function setIdObjectif($idObjectif)
    {
        $this->idObjectif = $idObjectif;
    }


    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getBut()
    {
        return $this->but;
    }

    /**
     * @param mixed $but
     */
    public function setBut($but)
    {
        $this->but = $but;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }


    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param \DateTime $start_date
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @param \DateTime $end_date
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
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
