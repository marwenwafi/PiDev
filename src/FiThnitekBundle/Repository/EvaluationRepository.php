<?php

namespace FiThnitekBundle\Repository;
use Doctrine\ORM\EntityRepository;

class EvaluationRepository extends EntityRepository
{
    public function afficherrating($id)
    {
        $query=$this->getEntityManager()->createQuery("SELECT c FROM FiThnitekBundle:Evaluation c where c.idClient= $id");
        return $query->getResult();
    }
    public function updatecomment($id,$c,$r)
    {
        $query=$this->getEntityManager()->createQuery("UPDATE FiThnitekBundle:Evaluation c SET c.commentaire='$c' , c.note='$r' where c.id=$id");
        return $query->getResult();
    }

    public function verifier($id,$idc)
    {
        $query=$this->getEntityManager()->createQuery("SELECT c FROM FiThnitekBundle:Evaluation c where c.idClient= '$id' and c.utilisateur=$idc");
        return $query->getResult();
    }
}
