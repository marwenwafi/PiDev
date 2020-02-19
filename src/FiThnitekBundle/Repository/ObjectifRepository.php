<?php

namespace FiThnitekBundle\Repository;

use Doctrine\ORM\EntityRepository;


class ObjectifRepository extends EntityRepository
{
    public function customQuery($type,$start,$end)
    {
        $query = "";

        if ($type == "Nombre Utilisateurs")
        {
            $query = "Select Count(U.id) from AppBundle:User U where U.registrationdate Between '$start' AND '$end'";
        }

        $q = $this->getEntityManager()
            ->createQuery($query);
        return $query = $q->getResult();
    }


}
