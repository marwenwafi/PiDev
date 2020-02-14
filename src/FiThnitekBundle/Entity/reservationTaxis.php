<?php


namespace FiThnitekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class reservationTaxis
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\user")
     * @ORM\JoinColumn(name="iduser",
     *     referencedColumnName="id")
     */
    private $iduser;


    /**
     * @ORM\ManyToOne(targetEntity="DemandeTaxi")
     * @ORM\JoinColumn(name="iddemande",
     *     referencedColumnName="id")
     */
    private $iddemande;

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
    public function getIddemande()
    {
        return $this->iddemande;
    }

    /**
     * @param mixed $iddemande
     */
    public function setIddemande($iddemande)
    {
        $this->iddemande = $iddemande;
    }


}