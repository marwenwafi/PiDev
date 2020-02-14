<?php


namespace FiThnitekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity (repositoryClass="FiThnitekBundle\Repository\ReponseRepository")
 */
class Reponse
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
     * @var string
     *
     * @ORM\Column(name="reponseRec", type="text")
     */
    private $reponseRec;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Reclamation")
     * @ORM\JoinColumn(name="id_rec",referencedColumnName="id")
     */
    private $id_rec;

    /**
     * @return mixed
     */
    public function getIdRec()
    {
        return $this->id_rec;
    }

    /**
     * @param mixed $id_rec
     */
    public function setIdRec($id_rec)
    {
        $this->id_rec = $id_rec;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getReponseRec()
    {
        return $this->reponseRec;
    }

    /**
     * @param string $reponseRec
     */
    public function setReponseRec($reponseRec)
    {
        $this->reponseRec = $reponseRec;
    }


}