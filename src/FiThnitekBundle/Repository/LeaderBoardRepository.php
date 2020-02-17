<?php

namespace FiThnitekBundle\Repository;

use Doctrine\ORM\EntityRepository;


class LeaderBoardRepository extends EntityRepository
{
    public function customQuery($cat,$size, $start,$end)
    {
        $query = "";

        if ($cat->getType() == "Taxi" && $cat->getNature() == "Avis")
        {

            //TODO According to what siwar and yassine do


            $query = "";
        }
        elseif ($cat->getType() == "Taxi" && $cat->getNature() == "Revenu")
        {

            //TODO According to what siwar does

            $query = "";
        }
        elseif ($cat->getType() == "Taxi" && $cat->getNature() == "Activite")
        {
            //TODO According to what siwar does

            $query = "select T.username, COUNT(O.id_offre_col) AS value from FiThnitekBundle:OffreColis O, AppBundle:User U WHERE O.idU = U.id AND O.date BETWEEN '$start' AND '$end' ORDER BY value DESC";
        }
        elseif ($cat->getType() == "Covoiturage" && $cat->getNature() == "Avis")
        {
            //TODO According to what yassine does

            $query = "";
        }
        elseif ($cat->getType() == "Covoiturage" && $cat->getNature() == "Revenu")
        {
            $query = "select U.username, SUM(R.prixt) AS value from FiThnitekBundle:offreCovoiturage O, FiThnitekBundle:ReservationCovoiturage R, AppBundle:User U WHERE R.idoffrer = O.idoffrecovoiturage AND U.id = O.idutilisateur AND O.date BETWEEN '$start' AND '$end' GROUP BY U.id ORDER BY value DESC";
         }
        elseif ($cat->getType() == "Covoiturage" && $cat->getNature() == "Activite")
        {
            $query = "select U.username, COUNT(O.idoffrecovoiturage) AS value from FiThnitekBundle:offreCovoiturage O, AppBundle:User U WHERE O.idutilisateur = U.id AND O.date BETWEEN '$start' AND '$end' ORDER BY value DESC";
        }
        elseif ($cat->getType() == "Colis" && $cat->getNature() == "Avis")
        {

            //TODO According to what yassine does

            $query = "";
        }
        elseif ($cat->getType() == "Colis" && $cat->getNature() == "Revenu")
        {
            $query = "select U.username, SUM(R.prix) AS value from FiThnitekBundle:OffreColis O, FiThnitekBundle:ReservationColis R, AppBundle:User U WHERE R.idOffre = O.id_offre_col AND U.id = O.idU AND O.date_col BETWEEN '$start' AND '$end' GROUP BY U.id ORDER BY value DESC";
        }
        elseif ($cat->getType() == "Colis" && $cat->getNature() == "Activite")
        {
            $query = "select U.username, COUNT(O.id_offre_col) AS value from FiThnitekBundle:OffreColis O, AppBundle:User U WHERE O.idU = U.id AND O.date BETWEEN '$start' AND '$end' ORDER BY value DESC";
        }
        else
        {

        }

        //select o from FiThnitekBundle:offreCovoiturage o Where o.date BETWEEN '$start' AND '$end'
        $q = $this->getEntityManager()
            ->createQuery($query);
        return $query = $q->getResult();
    }

    private function queryDecider($cat)
    {

    }

}
