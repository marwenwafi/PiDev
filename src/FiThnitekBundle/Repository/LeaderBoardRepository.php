<?php

namespace FiThnitekBundle\Repository;

use Doctrine\ORM\EntityRepository;


class LeaderBoardRepository extends EntityRepository
{
    public function test($start,$end)
    {
        $q = $this->getEntityManager()
            ->createQuery("select o from FiThnitekBundle:OffreCovoiturage o Where o.date BETWEEN '$start' AND '$end'");
        return $query = $q->getResult();
    }

}
