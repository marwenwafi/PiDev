<?php


namespace FiThnitekBundle\Repository;


use Doctrine\ORM\EntityRepository;

class CovoiturageRepository extends EntityRepository
{
    public function myfindoffre($idu,$datea)
    {
        $qb = $this->getEntityManager()->createQuery("select o from FiThnitekBundle:offreCovoiturage o where o.nbrplaceo != 0 and o.idutilisateur != $idu and o.date > '$datea'");
        return $query = $qb->getResult();
    }
    public function myrechercheoffre($nbrplace,$idu,$dater,$dest,$dept)
    {
        $qb = $this->getEntityManager()->createQuery("select o from FiThnitekBundle:offreCovoiturage o where o.nbrplaceo >= $nbrplace and o.idutilisateur != $idu and o.date = '$dater' and o.destination LIKE '%$dest%' and o.depart LIKE '%$dept%'");
        return $query = $qb->getResult();
    }
    public function ordonnerkbiroffre($idu,$datea)
    {
        $qb = $this->getEntityManager()->createQuery("select o from FiThnitekBundle:offreCovoiturage o where o.nbrplaceo != 0 and o.idutilisateur != $idu and o.date > '$datea' ORDER BY o.prix DESC");
        return $query = $qb->getResult();
    }
    public function ordonnersghiroffre($idu,$datea)
    {
        $qb = $this->getEntityManager()->createQuery("select o from FiThnitekBundle:offreCovoiturage o where o.nbrplaceo != 0 and o.idutilisateur != $idu and o.date > '$datea' ORDER BY o.prix ASC");
        return $query = $qb->getResult();
    }
    public function mycount($id)
    {
        $qb = $this->getEntityManager()->createQuery("select count(o) from FiThnitekBundle:ReservationCovoiturage o where o.idoffrer = $id ");
        return $query = $qb->getResult();
    }
    public function mytriedateadmin()
    {
        $qb = $this->getEntityManager()->createQuery("select o from FiThnitekBundle:offreCovoiturage o ORDER BY o.date DESC  ");
        return $query = $qb->getResult();
    }
    public function myrecherchBackeoffre($nbrplace,$datea,$dest,$dept)
    {
        $qb = $this->getEntityManager()->createQuery("select o from FiThnitekBundle:offreCovoiturage o where o.nbrplaceo >= $nbrplace and o.date = '$datea' and o.destination LIKE '%$dest%' and o.depart LIKE '%$dept%'");
        return $query = $qb->getResult();
    }

}