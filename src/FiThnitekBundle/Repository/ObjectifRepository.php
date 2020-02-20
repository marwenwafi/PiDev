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
        elseif ($type == "Revenues Totales")
        {
            $query = "Select SUM(TOT) from ((Select RC.Prix AS TOT from FiThnitekBundle:ReservationColis RC, FiThnitekBundle:OffreColis OC
             WHERE RC.idOffre = OC.idOffreCol AND OC.dateCol Between '$start' AND '$end') UNION ALL (Select R.prixt as TOT from FiThnitekBundle:ReservationCovoiturage R,
            FiThnitekBundle:offreCovoiturage O WHERE R.idoffrer = O.idoffrecovoiturage  AND O.date Between '$start' AND '$end')) t";

        }
        elseif ($type == "Activites Totales")
        {

        }
        elseif ($type == "Revenues Colis")
        {
            $query = "Select SUM(RC.Prix) from FiThnitekBundle:ReservationColis RC, FiThnitekBundle:OffreColis OC
             WHERE RC.idOffre = OC.idOffreCol AND OC.dateCol Between '$start' AND '$end'";
        }
        elseif ($type == "Activites Colis")
        {

        }
        elseif ($type == "Revenues Covoiturage")
        {
            $query = "Select SUM(R.prixt) from FiThnitekBundle:ReservationCovoiturage R, FiThnitekBundle:offreCovoiturage O
            WHERE R.idoffrer = O.idoffrecovoiturage AND O.date Between '$start' AND '$end'";
        }
        elseif ($type == "Activite Covoiturage")
        {

        }
        elseif ($type == "Revenues Taxi")
        {

        }
        elseif ($type == "Activite Taxi")
        {

        }

        $q = $this->getEntityManager()
            ->createQuery($query);
        return $query = $q->getResult();
    }


}
