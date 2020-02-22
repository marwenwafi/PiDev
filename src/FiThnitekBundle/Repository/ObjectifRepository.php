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
            //TODO still needs to add taxi
            return array_merge($this->customQuery("Revenues Covoiturage",$start,$end), $this->customQuery("Revenues Colis",$start,$end));
        }
        elseif ($type == "Activites Totales")
        {
            //TODO still needs to add taxi
            return array_merge($this->customQuery("Activites Covoiturage",$start,$end), $this->customQuery("Activites Colis",$start,$end));
        }
        elseif ($type == "Revenues Colis")
        {
            $query = "Select SUM(RC.Prix) from FiThnitekBundle:ReservationColis RC, FiThnitekBundle:OffreColis OC
             WHERE RC.idOffre = OC.idOffreCol AND OC.dateCol Between '$start' AND '$end'";
        }
        elseif ($type == "Activites Colis")
        {
            $query = "SELECT COUNT(RC.idReservationColis) FROM FiThnitekBundle:ReservationColis RC, FiThnitekBundle:OffreColis OC
             WHERE RC.idOffre = OC.idOffreCol AND OC.dateCol Between '$start' AND '$end'";
        }
        elseif ($type == "Revenues Covoiturage")
        {
            $query = "SELECT SUM(R.prixt) FROM FiThnitekBundle:ReservationCovoiturage R, FiThnitekBundle:offreCovoiturage O
            WHERE R.idoffrer = O.idoffrecovoiturage AND O.date Between '$start' AND '$end'";
        }
        elseif ($type == "Activites Covoiturage")
        {
            $query = "SELECT COUNT(R.idreservationcov) FROM FiThnitekBundle:ReservationCovoiturage R, FiThnitekBundle:offreCovoiturage O
            WHERE R.idoffrer = O.idoffrecovoiturage AND O.date Between '$start' AND '$end'";
        }
        elseif ($type == "Revenues Taxi")
        {
            // TODO
            $query = "SELECT SUM(R.prixt) from FiThnitekBundle:ReservationCovoiturage R, FiThnitekBundle:offreCovoiturage O
            WHERE R.idoffrer = O.idoffrecovoiturage AND O.date Between '$start' AND '$end'";
        }
        elseif ($type == "Activites Taxi")
        {
            //TODO
        }

        return $query = $this->getEntityManager()->createQuery($query)->getResult();
    }


}
