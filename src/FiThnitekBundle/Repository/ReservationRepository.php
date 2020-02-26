<?php


namespace FiThnitekBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ReservationRepository extends EntityRepository
{
    public function siwar($id)
    {

        $qb = $this->getEntityManager()->createQuery("select c from FiThnitekBundle:reservationTaxis c   where c.iduser=$id  ORDER BY  c.id DESC  ");
        return $query = $qb->getResult() ;
    }

}