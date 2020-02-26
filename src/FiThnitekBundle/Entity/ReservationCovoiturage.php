<?php


namespace FiThnitekBundle\Entity;
use Doctrine\ORM\Mapping as ORM ;
/**
 * @ORM\Entity (repositoryClass="FiThnitekBundle\Repository\CovoiturageRepository")
 */

class ReservationCovoiturage
{

    /**

     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="idutilisateurr",
     *  referencedColumnName="id")
     */
private $idutilisateurr;
    /**

     * @ORM\ManyToOne(targetEntity="OffreCovoiturage")
     * @ORM\JoinColumn(name="idoffrer",
     *  referencedColumnName="idoffrecovoiturage")
     */
    private $idoffrer;
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
private $idreservationcov;
    /**
     * @ORM\Column(type="integer")
     */
private $nbrplacer;
    /**
     * @ORM\Column(type="float")
     */
private $prixt ;

    /**
     * @return mixed
     */
    public function getIdutilisateurr()
    {
        return $this->idutilisateurr;
    }

    /**
     * @param mixed $idutilisateurr
     */
    public function setIdutilisateurr($idutilisateurr)
    {
        $this->idutilisateurr = $idutilisateurr;
    }

    /**
     * @return mixed
     */
    public function getIdoffrer()
    {
        return $this->idoffrer;
    }

    /**
     * @param mixed $idoffrer
     */
    public function setIdoffrer($idoffrer)
    {
        $this->idoffrer = $idoffrer;
    }

    /**
     * @return mixed
     */
    public function getIdreservationcov()
    {
        return $this->idreservationcov;
    }

    /**
     * @param mixed $idreservationcov
     */
    public function setIdreservationcov($idreservationcov)
    {
        $this->idreservationcov = $idreservationcov;
    }

    /**
     * @return mixed
     */
    public function getNbrplacer()
    {
        return $this->nbrplacer;
    }

    /**
     * @param mixed $nbrplacer
     */
    public function setNbrplacer($nbrplacer)
    {
        $this->nbrplacer = $nbrplacer;
    }

    /**
     * @return mixed
     */
    public function getPrixt()
    {
        return $this->prixt;
    }

    /**
     * @param mixed $prixt
     */
    public function setPrixt($prixt)
    {
        $this->prixt = $prixt;
    }




}