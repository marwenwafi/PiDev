<?php

namespace FiThnitekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Convertirpoints
 *
 * @ORM\Table(name="convertirpoints")
 * @ORM\Entity(repositoryClass="FiThnitekBundle\Repository\ConvertirpointsRepository")
 */
class Convertirpoints
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
     * @ORM\JoinColumn(name="iduser"),
     * ReferencedColumnName="id")
     */
    private $iduser;



    /**
     * @var int
     *
     * @ORM\Column(name="cadeau", type="string")
     */
    private $cadeau;

    /**
     * Convertirpoints constructor.
     * @param $iduser
     * @param int $cadeau
     */
    public function __construct($iduser, $cadeau)
    {
        $this->iduser = $iduser;
        $this->cadeau = $cadeau;
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
     * @return int
     */
    public function getCadeau()
    {
        return $this->cadeau;
    }

    /**
     * @param int $cadeau
     */
    public function setCadeau($cadeau)
    {
        $this->cadeau = $cadeau;
    }



}

