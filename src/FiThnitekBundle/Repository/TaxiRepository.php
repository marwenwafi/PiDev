<?php


namespace FiThnitekBundle\Repository;


use Doctrine\ORM\EntityRepository;

class TaxiRepository extends EntityRepository
{
    public function affichagedemande($id)
    {
        $date=new \DateTime();

        $daten=$date->format(' Y-m-d');
        $periode=$date->format('H:i');
        $qb = $this->getEntityManager()->createQuery("select c from FiThnitekBundle:DemandeTaxi c   where c.iduser != '$id' and c.etat=0 and ((c.periode >= '$periode'  and c.dateD ='$daten') or (c.dateD >'$daten')) ORDER BY  c.id DESC  ");
        return $query = $qb->getResult() ;
    }
    public function recherchedrld($id , $region , $lieud , $date)
    {

        $qb = $this->getEntityManager()->createQuery("select c from FiThnitekBundle:DemandeTaxi c   where c.iduser != '$id' and c.region= '$region' and c.lieudedepart = '$lieud' and c.etat=0 and c.dateD ='$date' ORDER BY  c.id DESC  ");
        return $query = $qb->getResult() ;
    }


    public function trierselonprice($id)
    {
        $date=new \DateTime();

        $daten=$date->format(' Y-m-d');
        $periode=$date->format('H:i');
        $qb = $this->getEntityManager()->createQuery("select c from FiThnitekBundle:DemandeTaxi c   where c.iduser != '$id' and c.etat=0 and ((c.periode >= '$periode'  and c.dateD ='$daten') or (c.dateD >'$daten')) ORDER BY  c.prix DESC  ");
        return $query = $qb->getResult() ;
    }
    public function etat1()
    {

        $qb = $this->getEntityManager()->createQuery("select c from FiThnitekBundle:DemandeTaxi c   where  c.etat=1  ORDER BY  c.id DESC  ");
        return $query = $qb->getResult() ;
    }
    public function etat0()
    {

        $qb = $this->getEntityManager()->createQuery("select c from FiThnitekBundle:DemandeTaxi c   where  c.etat=0  ORDER BY  c.id DESC  ");
        return $query = $qb->getResult() ;
    }

    public function region($region,$datej)
    {     $date=new \DateTime();

        //$daten=$date->format(' Y-m-d');
        $periode=$date->format('H:i');

        $qb = $this->getEntityManager()->createQuery("select c from FiThnitekBundle:DemandeTaxi c   where c.region='$region' and c.etat =0 and (c.periode >= '$periode'  and c.dateD ='$datej')   ORDER BY  c.id DESC  ");
        return $query = $qb->getResult() ;
    }
    public function regiononly($region)
    {

        $qb = $this->getEntityManager()->createQuery("select c from FiThnitekBundle:DemandeTaxi c   where c.region='$region'    ORDER BY  c.id DESC  ");
        return $query = $qb->getResult() ;
    }

    public function region2($region,$datej)
    {     $date=new \DateTime();

        //$daten=$date->format(' Y-m-d');
        $periode=$date->format('H:i');

        $qb = $this->getEntityManager()->createQuery("select c from FiThnitekBundle:DemandeTaxi c   where c.region='$region' and c.etat =0 and ( c.dateD ='$datej')   ORDER BY  c.id DESC  ");
        return $query = $qb->getResult() ;
    }
    public function date($date)
    {

        $qb = $this->getEntityManager()->createQuery("select c from FiThnitekBundle:DemandeTaxi c   where c.periode='$date'  and c.etat=0  and c.periode > '09:30' ORDER BY  c.id DESC  ");
        return $query = $qb->getResult() ;
    }

    public function triprix()
    {

        $qb = $this->getEntityManager()->createQuery("select c from FiThnitekBundle:DemandeTaxi c   where  c.etat=0  and c.periode > '09:30' ORDER BY  c.prix  DESC  ");
        return $query = $qb->getResult() ;
    }
    public function trihour()
    {    $date=new \DateTime();

        $daten=$date->format(' Y-m-d');
        $periode=$date->format('H:i');

        $qb = $this->getEntityManager()->createQuery("select c from FiThnitekBundle:DemandeTaxi c   where  c.etat=0  and (c.periode >= '$periode'  and c.dateD ='$daten') or (c.dateD >'$daten') ORDER BY  c.dateD  ASC   ");
        return $query = $qb->getResult() ;
    }


}