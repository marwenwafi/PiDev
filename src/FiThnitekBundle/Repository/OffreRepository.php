<?php


namespace FiThnitekBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class OffreRepository extends EntityRepository
{

    public function MyOffre($id)
    {

$hauteur=0;
$largeur=0;
        $date=new \DateTime();
        $d=$date->format('Y-m-d');
        $qb=$this->getEntityManager()->createQuery("select c from FiThnitekBundle:OffreColis c where c.dateCol >='$d'
        and c.idU != $id and c.longueur > '0' and c.largeur > '0'
");
        return $query=$qb->getResult();
    }
    public function findDate($Date,$Prix,$id)
    {
        $qb=$this->getEntityManager()->createQuery("select c from FiThnitekBundle:OffreColis c where c.dateCol  >= '$Date' and c.prix <= '$Prix' and c.idU != $id and c.longueur > '0' and c.largeur > '0'   ");
        return $query=$qb->getResult();
    }
    public function trier()
    {
        $qb=$this->getEntityManager()->createQuery("select c from FiThnitekBundle:OffreColis c ORDER BY c.dateCol DESC");
        return $query=$qb->getResult();
    }

}