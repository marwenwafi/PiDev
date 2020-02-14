<?php

namespace FiThnitekBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ReponseRepository extends EntityRepository
{
    public function reponseadmin($id)
    {
        $query=$this->getEntityManager()->createQuery("SELECT c FROM FiThnitekBundle:Reponse c where c.id_rec=$id" );

        return $query->getResult();
    }
    public function removereponse($id)
    {
        $query=$this->getEntityManager()->createQuery("DELETE FROM FiThnitekBundle:Reponse c where c.id_rec=$id" );

        return $query->getResult();
    }
}
