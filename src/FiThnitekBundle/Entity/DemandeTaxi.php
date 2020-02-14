<?php


namespace FiThnitekBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */

class DemandeTaxi
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $lieudedepart;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $lieudarrive;
    /**
     * @ORM\Column(type="string")
     */
    private $periode;

    /**
     * @ORM\Column(type="integer")
     */
    private $etat;
    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="iduser",
     *     referencedColumnName="id")
     */
    private $iduser;

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
    public function getLieudedepart()
    {
        return $this->lieudedepart;
    }

    /**
     * @param mixed $lieudedepart
     */
    public function setLieudedepart($lieudedepart)
    {
        $this->lieudedepart = $lieudedepart;
    }

    /**
     * @return mixed
     */
    public function getLieudarrive()
    {
        return $this->lieudarrive;
    }

    /**
     * @param mixed $lieudarrive
     */
    public function setLieudarrive($lieudarrive)
    {
        $this->lieudarrive = $lieudarrive;
    }

    /**
     * @return mixed
     */
    public function getPeriode()
    {
        return $this->periode;
    }

    /**
     * @param mixed $periode
     */
    public function setPeriode($periode)
    {
        $this->periode = $periode;
    }




}