<?php


namespace FiThnitekBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;

/**
 * @ORM\Entity(repositoryClass="FiThnitekBundle\Repository\TaxiRepository")
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
     * @ORM\Column(type="string",length=255)
     */
    private $region;
    /**
     *
     * @ORM\Column(type="string",length=255)
     *
     */
    private $periode;
    /**
     *
     * @ORM\Column(type="string",length=255)
     *
     */
    private $dateD;

    /**
     * @ORM\Column(type="integer")
     */
    private $etat;
    /**
     * @ORM\Column(type="float")
     */
    private $prix;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="iduser",
     *     referencedColumnName="id")
     */
    private $iduser;


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
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return mixed
     */
    public function getDateD()
    {
        return $this->dateD;
    }

    /**
     * @param mixed $dateD
     */
    public function setDateD($dateD)
    {
        $this->dateD = $dateD;
    }


    /*
    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        $notification= new Notification();
        //$user = $this->container->get('security.token_storage')->getToken()->getUser();

        $notification
            ->setTitle('ajout demande')
            ->setDescription('vous avez fait une demande de taxi ')
            ->setRoute('fi_thnitek_affichedemandeuser')
            ->setParameters(array('id'=> $this->id));
            //->setIduser(array('iduser'=>$this->iduser));
          $builder->addNotification($notification);
        return $builder;
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        $notification= new Notification();

        $notification
            ->setTitle('mise a jour demande')
            ->setDescription('vous avez fait une demande de taxi ')
            ->setRoute('fi_thnitek_affichedemandeuser')
            ->setParameters(array('id'=> $this->id));

        $builder->addNotification($notification);
        return $builder;    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {   //$user = $this->container->get('security.token_storage')->getToken()->getUser();

        $notification= new Notification();
        $notification
            ->setTitle('supprimer demande')
            ->setDescription('vous avez fait une demande de taxi ')
            ->setRoute('fi_thnitek_affichedemandeuser')
            ->setParameters(array('id'=> $this->id));

        $builder->addNotification($notification);
        return $builder;
    }
*/


}