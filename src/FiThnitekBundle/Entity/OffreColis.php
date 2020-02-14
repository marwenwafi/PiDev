<?php


namespace FiThnitekBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 */
class OffreColis
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="idU",
     *     referencedColumnName="id")
     */
    private $idU;
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private  $idOffreCol;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $dateCol;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $lieuDepart;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $Voiture;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $lieuArrive;
    /**
     * @ORM\Column(type="integer")
     */
    private $prix;
    /**
     * @ORM\Column(type="float")
     */
    private $hauteur;
    /**
     * @ORM\Column(type="float")
     */
    private $largeur;

    /**
     * @return mixed
     */
    public function getIdU()
    {
        return $this->idU;
    }

    /**
     * @param mixed $idU
     */
    public function setIdU($idU)
    {
        $this->idU = $idU;
    }

    /**
     * @return mixed
     */
    public function getIdOffreCol()
    {
        return $this->idOffreCol;
    }

    /**
     * @param mixed $idOffreCol
     */
    public function setIdOffreCol($idOffreCol)
    {
        $this->idOffreCol = $idOffreCol;
    }

    /**
     * @return mixed
     */
    public function getDateCol()
    {
        return $this->dateCol;
    }

    /**
     * @param mixed $dateCol
     */
    public function setDateCol($dateCol)
    {
        $this->dateCol = $dateCol;
    }

    /**
     * @return mixed
     */
    public function getLieuDepart()
    {
        return $this->lieuDepart;
    }

    /**
     * @param mixed $lieuDepart
     */
    public function setLieuDepart($lieuDepart)
    {
        $this->lieuDepart = $lieuDepart;
    }

    /**
     * @return mixed
     */
    public function getLieuArrive()
    {
        return $this->lieuArrive;
    }

    /**
     * @param mixed $lieuArrive
     */
    public function setLieuArrive($lieuArrive)
    {
        $this->lieuArrive = $lieuArrive;
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

    /**
     * @return mixed
     */
    public function getHauteur()
    {
        return $this->hauteur;
    }

    /**
     * @return mixed
     */
    public function getVoiture()
    {
        return $this->Voiture;
    }

    /**
     * @param mixed $Voiture
     */
    public function setVoiture($Voiture)
    {
        $this->Voiture = $Voiture;
    }

    /**
     * @param mixed $hauteur
     */
    public function setHauteur($hauteur)
    {
        $this->hauteur = $hauteur;
    }

    /**
     * @return mixed
     */
    public function getLargeur()
    {
        return $this->largeur;
    }

    /**
     * @param mixed $largeur
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;
    }

}