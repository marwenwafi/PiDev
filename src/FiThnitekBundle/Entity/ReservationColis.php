<?php


namespace FiThnitekBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class ReservationColis
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="idUR",
     *     referencedColumnName="id")
     */
    private $idUR;
    /**
     * @ORM\ManyToOne(targetEntity="OffreColis")
     * @ORM\JoinColumn(name="idOffre",
     *     referencedColumnName="id_offre_col")
     */
    private $idOffre;
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private  $idReservationColis;
    /**
     * @ORM\Column(type="float")
     */
    private $HauteurResv;
    /**
     * @ORM\Column(type="float")
     */
    private $LargeurResv;
    /**
     * @ORM\Column(type="float")
     */
    private $Prix;

    /**
     * @return mixed
     */
    public function getIdUR()
    {
        return $this->idUR;
    }

    /**
     * @param mixed $idUR
     */
    public function setIdUR($idUR)
    {
        $this->idUR = $idUR;
    }

    /**
     * @return mixed
     */
    public function getIdOffre()
    {
        return $this->idOffre;
    }

    /**
     * @param mixed $idOffre
     */
    public function setIdOffre($idOffre)
    {
        $this->idOffre = $idOffre;
    }

    /**
     * @return mixed
     */
    public function getIdReservationColis()
    {
        return $this->idReservationColis;
    }

    /**
     * @param mixed $idReservationColis
     */
    public function setIdReservationColis($idReservationColis)
    {
        $this->idReservationColis = $idReservationColis;
    }

    /**
     * @return mixed
     */
    public function getHauteurResv()
    {
        return $this->HauteurResv;
    }

    /**
     * @param mixed $HauteurResv
     */
    public function setHauteurResv($HauteurResv)
    {
        $this->HauteurResv = $HauteurResv;
    }

    /**
     * @return mixed
     */
    public function getLargeurResv()
    {
        return $this->LargeurResv;
    }

    /**
     * @param mixed $LargeurResv
     */
    public function setLargeurResv($LargeurResv)
    {
        $this->LargeurResv = $LargeurResv;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->Prix;
    }

    /**
     * @param mixed $Prix
     */
    public function setPrix($Prix)
    {
        $this->Prix = $Prix;
    }



}