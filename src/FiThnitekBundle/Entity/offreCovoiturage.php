<?php


namespace FiThnitekBundle\Entity;
use Doctrine\ORM\Mapping as ORM ;
/**
 * @ORM\Entity
 */

class offreCovoiturage
{

    /**

     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="idutilisateur",
     *  referencedColumnName="id")
     */
private $idutilisateur;
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
private $idoffrecovoiturage;
    /**
     * @ORM\Column(type="string",length=255)
     */
private $destination;

    /**
     * @ORM\Column(type="string",length=255)
     */

private $depart;

    /**
     * @ORM\Column(type="string",length=255)
     */

private $date;

    /**
     * @ORM\Column(type="integer")
     */

private $nbrplaceo;

/**
     * @ORM\Column(type="float")
     */

private $prix ;

    /**
     * @return mixed
     */
    public function getIdutilisateur()
    {
        return $this->idutilisateur;
    }

    /**
     * @param mixed $idutilisateur
     */
    public function setIdutilisateur($idutilisateur)
    {
        $this->idutilisateur = $idutilisateur;
    }

    /**
     * @return mixed
     */
    public function getIdoffrecovoiturage()
    {
        return $this->idoffrecovoiturage;
    }

    /**
     * @param mixed $idoffrecovoiturage
     */
    public function setIdoffrecovoiturage($idoffrecovoiturage)
    {
        $this->idoffrecovoiturage = $idoffrecovoiturage;
    }

    /**
     * @return mixed
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param mixed $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * @return mixed
     */
    public function getDepart()
    {
        return $this->depart;
    }

    /**
     * @param mixed $depart
     */
    public function setDepart($depart)
    {
        $this->depart = $depart;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getNbrplaceo()
    {
        return $this->nbrplaceo;
    }

    /**
     * @param mixed $nbrplaceo
     */
    public function setNbrplaceo($nbrplaceo)
    {
        $this->nbrplaceo = $nbrplaceo;
    }

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


}