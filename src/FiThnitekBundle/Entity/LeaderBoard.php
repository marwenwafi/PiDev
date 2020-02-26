<?php
// src/AppBundle/Entity/User.php

namespace FiThnitekBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Entity (repositoryClass="FiThnitekBundle\Repository\LeaderBoardRepository")
 * @Vich\Uploadable
 */
class LeaderBoard
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idleaderboard;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(0)
     */
    private $size;

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
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category", referencedColumnName="id_category")
     */
    private $category;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="leaderboard_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    // ...

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    /**
     * LeaderBoard constructor.
     */
    public function __construct()
    {
        $this->start_date = new \DateTime();
        $this->end_date = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getIdleaderboard()
    {
        return $this->idleaderboard;
    }

    /**
     * @param mixed $idleaderboard
     */
    public function setIdleaderboard($idleaderboard)
    {
        $this->idleaderboard = $idleaderboard;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param mixed $start_date
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @param mixed $end_date
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * @param mixed $banner
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;
    }

}
