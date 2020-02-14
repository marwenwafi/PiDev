<?php

namespace FiThnitekBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ReclamationRepository extends EntityRepository
{
    public function backreclamation()
    {
        $query=$this->getEntityManager()->createQuery("SELECT c FROM FiThnitekBundle:Reclamation c where c.etat!=1");
        return $query->getResult();
    }
    public function updateetat($id)
    {
        $query=$this->getEntityManager()->createQuery("UPDATE FiThnitekBundle:Reclamation c SET c.etat=1 where c.id=$id");

        //$query=$this->createQueryBuilder();
        //$query->update('c')->from('FiThnitekBundle:Reclamation','c')->set('c.etat=1')->where('c.id=:id')->setParameter('id',$id);
        return $query->getResult();
    }
}
