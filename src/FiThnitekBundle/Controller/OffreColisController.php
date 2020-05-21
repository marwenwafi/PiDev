<?php

namespace FiThnitekBundle\Controller;

use AppBundle\Entity\User;
use Esprit\ApiBundle\Entity\Task;
use FiThnitekBundle\Entity\OffreColis;
use FiThnitekBundle\Entity\ReservationColis;
use QRcode;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

//include "../../../vendor/phpqrcode/qrlib.php";
//use vendor\phpqrcode\qrlib.php;
include "../vendor/phpqrcode/qrlib.php";

class OffreColisController extends Controller
{
    public function indexAction()
    {
        return $this->render('@FiThnitek/FiThnitek/index.html.twig');
    }

    public function loginAction()
    {
        return $this->render('@FiThnitek/FiThnitek/login.html.twig');
    }
    public function OffreColisAction()
    {
        return $this->render('@FiThnitek/FiThnitek/OffreColis.html.twig');
    }

    public function ajouteroffrecolisAction(Request $request)
    {
        $date=new \DateTime();
        $d=$date->format('Y-m-d');
        $upd=$this->getDoctrine()->getManager();
        $Offre=new OffreColis();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($request->isMethod('POST') && ( $d <= $request->get('Date')))
        {

            $Offre->setIdU($user);
            $Offre->setLieuDepart($request->get('Depart'));
            $Offre->setDateCol($request->get('Date'));
            $Offre->setHauteur($request->get('Hauteur'));
            $Offre->setLargeur($request->get('Largeur'));
            $Offre->setLongueur($request->get('Longueur'));

            $Offre->setVoiture($request->get('Modele'));
            $Offre->setLieuArrive($request->get('Arrive'));
            $Offre->setPrix($request->get('Prix'));
            $user->setNbroffre($user->getNbroffre()+1);
            $upd->persist($Offre);
            $upd->flush();
            $Longueur = $Offre->getLongueur();

            $Prix = $Offre->getPrix();
            $Hauteur = $Offre->getHauteur();
            $Largeur = $Offre->getLargeur();
            $Arrive=$Offre->getLieuArrive();
            $Depart=$Offre->getLieuDepart();
            $Date=$Offre->getDateCol();
            $chaine = "Prix:" . $Prix . "  Largeur: " . $Largeur . "Hauteur:" . $Hauteur ."Longueur:".$Longueur ."user".$user."Arrive".$Arrive."Depart".$Depart."Date".$Date;
            QRcode::png($chaine, "QrAjouterOffreFront.png", "H", 20, 20);
            return $this->redirectToRoute("fi_thnitek_afficherOffre");
        }
        return $this->render('@FiThnitek/FiThnitek/OffreColis.html.twig',array('Offre'=> $Offre
        ));

    }
    public function afficherOffreAction()
    {
        //   QRcode::png("maha bagra", "jas.png", "H", 20, 20);

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em=$this->getDoctrine()->getRepository(OffreColis::class)->findBy(array('idU'=>$user->getId()));
        return $this->render('@FiThnitek/FiThnitek/affichageColisutilisateur.html.twig',array('r'=>$em));

    }
    public function supprimerOffreAction($id)
    {
        $supp=$this->getDoctrine()->getManager();
        $ids=$this->getDoctrine()->getRepository(OffreColis::class)->find($id);
        $supp->remove($ids);
        $supp->flush();
        return $this->redirectToRoute('fi_thnitek_afficherOffre');
    }
    public function ModifierOffreAction(Request $request,$id)
    {   $upd=$this->getDoctrine()->getManager();
        $Offre=$this->getDoctrine()->getRepository(OffreColis::class)->find($id);
        if ($request->isMethod('POST'))
        {

            $Offre->setLieuDepart($request->get('Depart'));
            $Offre->setDateCol($request->get('Date'));
            $Offre->setHauteur($request->get('Hauteur'));
            $Offre->setLargeur($request->get('Largeur'));
            $Offre->setLongueur($request->get('Longueur'));
            $Offre->setVoiture($request->get('Modele'));
            $Offre->setLieuArrive($request->get('Arrive'));
            $Offre->setPrix($request->get('Prix'));
            $upd->flush();
            return $this->redirectToRoute('fi_thnitek_afficherOffre');

        }
        return $this->render('@FiThnitek/FiThnitek/ModifierOffreColis.html.twig',array('Offre'=> $Offre
        ));



        #  return $this->redirectToRoute("club_readbase");

    }
    public function afficherallAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id=$user->getId();
        $em=$this->getDoctrine()->getRepository(OffreColis::class)->MyOffre($id);
        return $this->render('@FiThnitek/FiThnitek/affichageallColis.html.twig',array('r'=>$em));
    }
    public function ajouterReservationAction(Request $request,$id)
    {
        $upd = $this->getDoctrine()->getManager();
        $Reservation = new ReservationColis();
        //  $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id2=$user->getId();
        $Offre = $this->getDoctrine()->getRepository(OffreColis::class)->find($id);
        $em = $this->getDoctrine()->getRepository(OffreColis::class)->MyOffre($id2);

        if (($request->isMethod('POST')) && ($Offre->getHauteur() >= $request->get('Hauteur')) && ($Offre->getLargeur() >= $request->get('Largeur')) && ($Offre->getLongueur() >= $request->get('Longueur'))) {
            //   if (($Offre->getHauteur() <= $request->get('Hauteur')) && ($Offre->getLargeur() <= $request->get('Largeur'))) {
            $Prix = $Offre->getPrix();
            $idU=$Offre->getIdU()->getUsername();
            //    $PrixOffre = $Reservation->getPrix();
            $hauteur = $Offre->getHauteur();
            $largeur = $Offre->getLargeur();
            $longueur = $Offre->getlongueur();
            $Reservation->setIdOffre($Offre);
            $Reservation->setIdUR($user);
            $Reservation->setHauteurResv($request->get('Hauteur'));
            $Reservation->setLargeurResv($request->get('Largeur'));
            $Reservation->setLongueurResv($request->get('Longueur'));

            $Reservation->setPrix($request->get('Longueur') *$request->get('Hauteur') * $request->get('Largeur') * $Prix);
            $Offre->setLongueur($longueur - $request->get('Longueur'));
            $Offre->setLargeur($largeur - $request->get('Largeur'));
            $m = $request->get('Largeur');
            $Hauteur = $request->get('Hauteur');
            $Longeur=$request->get('Longueur');
            $chaine = "Prix:" . $Prix . "  Largeur: " . $m . "Hauteur:" . $Hauteur ."Longueur: ".$Longeur. $user.$idU;
            QRcode::png($chaine, "QrReseFront.png", "H", 20, 20);


            $upd->persist($Reservation);
            $upd->persist($Offre);
            $upd->flush();
            return $this->redirectToRoute("fi_thnitek_affichageReservation");
            //  return $this->render('@FiThnitek/FiThnitek/login.html.twig',array('r'=> $Reservation));
        }
        //  }

        return $this->render('@FiThnitek/FiThnitek/affichageallColis.html.twig', array('r' => $em));

    }

    public function afficherReserverAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em=$this->getDoctrine()->getRepository(ReservationColis::class)->findBy(array('idUR'=>$user->getId()));
        return $this->render('@FiThnitek/FiThnitek/affichageReserverColisutilisateur.html.twig',array('r'=>$em));
    }
    public function supprimerReserverAction($id)
    {
        $supp=$this->getDoctrine()->getManager();
        $ids=$this->getDoctrine()->getRepository(ReservationColis::class)->find($id);
        $hauteur = $ids->getLongueurResv();
        $largeur=$ids->getLargeurResv();
        $ido=$ids->getIdOffre();
        $Offre = $this->getDoctrine()->getRepository(OffreColis::class)->find($ido);
        $Offre->setLongueur($hauteur + $Offre->getLongueur() );
        $Offre->setLargeur($largeur + $Offre->getLargeur());

        $supp->persist($Offre);

        $supp->remove($ids);
        $supp->flush();
        return $this->redirectToRoute('fi_thnitek_affichageReservation');
    }
////////////////////////////////Back///////////////////////////////////////////////////
    public function afficherOffrebackAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em=$this->getDoctrine()->getRepository(OffreColis::class)->trier();
        return $this->render('@FiThnitek/FiThnitek/affichageoffrecolisback.html.twig',array('r'=>$em));
    }
    public function ajouteroffrecolisbackAction(Request $request)
    {
        $date=new \DateTime();
        $d=$date->format('Y-m-d');
        $upd=$this->getDoctrine()->getManager();
        $Offre=new OffreColis();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($request->isMethod('POST') && ( $d <= $request->get('Date'))
        )
        {
            $Offre->setIdU($user);
            $Offre->setLieuDepart($request->get('Depart'));
            $Offre->setDateCol($request->get('Date'));
            $Offre->setHauteur($request->get('Hauteur'));
            $Offre->setLargeur($request->get('Largeur'));
            $Offre->setLongueur($request->get('Longueur'));
            $Offre->setVoiture($request->get('Modele'));
            $Offre->setLieuArrive($request->get('Arrive'));
            $Offre->setPrix($request->get('Prix'));

            $upd->persist($Offre);
            $upd->flush();
            $Longueur = $Offre->getLongueur();

            $Prix = $Offre->getPrix();
            $Hauteur = $Offre->getHauteur();
            $Largeur = $Offre->getLargeur();
            $Arrive=$Offre->getLieuArrive();
            $Depart=$Offre->getLieuDepart();
            $Date=$Offre->getDateCol();
            $chaine = "Prix:" . $Prix . "  Largeur: " . $Largeur . "Hauteur:" . $Hauteur ."Longueur:".$Longueur ."user".$user."Arrive".$Arrive."Depart".$Depart."Date".$Date;
            QRcode::png($chaine, "QrAjouterOffreBack.png", "H", 20, 20);
            return $this->redirectToRoute('fi_thnitek_afficherOffreback');
        }
        return $this->render('@FiThnitek/FiThnitek/ajouterOffreBack.html.twig');
    }
    public function supprimerOffrebackAction($id)
    {
        $supp=$this->getDoctrine()->getManager();
        $ids=$this->getDoctrine()->getRepository(OffreColis::class)->find($id);
        $supp->remove($ids);
        $supp->flush();
        return $this->redirectToRoute('fi_thnitek_afficherOffreback');
    }
    public function ModifierOffrebackAction(Request $request,$id)
    {   $upd=$this->getDoctrine()->getManager();
        $Offre=$this->getDoctrine()->getRepository(OffreColis::class)->find($id);
        if ($request->isMethod('POST'))
        {

            $Offre->setLieuDepart($request->get('Depart'));
            $Offre->setDateCol($request->get('Date'));
            $Offre->setHauteur($request->get('Hauteur'));
            $Offre->setLargeur($request->get('Largeur'));
            $Offre->setLongueur($request->get('Longueur'));
            $Offre->setVoiture($request->get('Modele'));
            $Offre->setLieuArrive($request->get('Arrive'));
            $Offre->setPrix($request->get('Prix'));
            $upd->flush();
            return $this->redirectToRoute('fi_thnitek_afficherOffreback');

        }
        return $this->render('@FiThnitek/FiThnitek/modifiercolisback.html.twig',array('Offre'=> $Offre
        ));



        #  return $this->redirectToRoute("club_readbase");

    }
    public function ajouterReservationbackAction(Request $request,$id)
    {
        $upd=$this->getDoctrine()->getManager();
        $Reservation=new ReservationColis();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Offre=$this->getDoctrine()->getRepository(OffreColis::class)->find($id);

        if (($request->isMethod('POST')) && ($Offre->getHauteur() >= $request->get('Hauteur')) && ($Offre->getLargeur() >= $request->get('Largeur')))
        {
            $Prix = $Offre->getPrix();
            $idU=$Offre->getIdU()->getUsername();
            $PrixOffre = $Reservation->getPrix();
            //    $hauteur = $Offre->getHauteur();
            $largeur = $Offre->getLargeur();
            $Longueur=$Offre->getLongueur();
            $Reservation->setIdOffre($Offre);
            $Reservation->setIdUR($user);
            $Reservation->setHauteurResv($request->get('Hauteur'));
            $Reservation->setLargeurResv($request->get('Largeur'));
            $Reservation->setLongueurResv($request->get('Longueur'));

            //    $Reservation->setPrix($request->get('Hauteur')*$request->get('Largeur'));
            $Reservation->setPrix($request->get('Longueur')*$request->get('Hauteur') * $request->get('Largeur') * $Prix);
            //  $Offre->setPrix($Prix - $PrixOffre);
            $Offre->setLongueur($Longueur - $request->get('Longueur'));
            $Offre->setLargeur($largeur - $request->get('Largeur'));
            $m = $request->get('Largeur');
            $Hauteur = $request->get('Hauteur');
            $chaine = "Admin Reservation ="."Prix:" . $Prix . "  Largeur: " . $m . "Hauteur:" . $Hauteur . $user.$idU;
            QRcode::png($chaine, "QrResevback.png", "H", 20, 20);
            $upd->persist($Offre);
            $upd->persist($Reservation);
            $upd->flush();
            return $this->redirectToRoute('fi_thnitek_affichageReservationback');
        }
        return $this->redirectToRoute('fi_thnitek_afficherOffreback');

    }
    public function afficherReserverbackAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em=$this->getDoctrine()->getRepository(ReservationColis::class)->findAll();
        return $this->render('@FiThnitek/FiThnitek/affichagereservercolisback.html.twig',array('r'=>$em));
    }
    public function supprimerReserverbackAction($id)
    {
        $supp=$this->getDoctrine()->getManager();
        $ids=$this->getDoctrine()->getRepository(ReservationColis::class)->find($id);
        $longueur = $ids->getLongueurResv();
        $largeur=$ids->getLargeurResv();
        $ido=$ids->getIdOffre();
        $Offre = $this->getDoctrine()->getRepository(OffreColis::class)->find($ido);
        $Offre->setLongueur($longueur + $Offre->getLongueur() );
        $Offre->setLargeur($largeur + $Offre->getLargeur());

        $supp->persist($Offre);
        $supp->remove($ids);
        $supp->flush();
        return $this->redirectToRoute('fi_thnitek_affichageReservationback');
    }
    public function rechercheDateAction(Request $request)
    {

        if($request->isMethod('POST')) #test aa buton
        {

            $Date=$request->get('Date');
            $Prix=$request->get('prix');
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id=$user->getId();
            $em=$this->getDoctrine()->getManager()->getRepository(OffreColis::class)->findDate($Date,$Prix,$id);

            return $this->render('@FiThnitek/FiThnitek/affichageallColis.html.twig',array('r'=>$em));

        }
        else
        {
            $em=$this->getDoctrine()->getRepository(OffreColis::class)->MyOffre();
            return $this->render('@FiThnitek/FiThnitek/affichageallColis.html.twig',array('r'=>$em));
        }


    }
    public function rechercheDatebackAction(Request $request)
    {

        if($request->isMethod('POST')) #test aa buton
        {

            $Date=$request->get('Date');
            $Prix=$request->get('prix');
            $em=$this->getDoctrine()->getManager()->getRepository(OffreColis::class)->findDateback($Date,$Prix);

            return $this->render('@FiThnitek/FiThnitek/affichageoffrecolisback.html.twig',array('r'=>$em));

        }
        else
        {
            $em=$this->getDoctrine()->getRepository(OffreColis::class)->MyOffre();
            return $this->render('@FiThnitek/FiThnitek/affichageoffrecolisback.html.twig',array('r'=>$em));
        }


    }
    /////////////////////Mobile////////////////////////////////////////////

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Offre = new OffreColis();
        $user=$this->getDoctrine()->getManager()->getRepository(User::class)->find($request->get('id'));
        $Offre->setLieuDepart($request->get('Depart'));
        $Offre->setDateCol($request->get('Date'));
        $Offre->setHauteur($request->get('Hauteur'));
        $Offre->setLargeur($request->get('Largeur'));
        $Offre->setLongueur($request->get('Longueur'));
        $Offre->setVoiture($request->get('Modele'));
        $Offre->setLieuArrive($request->get('Arrive'));
        $Offre->setPrix($request->get('Prix'));
        $Offre->setIdU($user);
        $em->persist($Offre);
        $em->flush();
        $Longueur = $Offre->getLongueur();
        $Prix = $Offre->getPrix();
        $Hauteur = $Offre->getHauteur();
        $Largeur = $Offre->getLargeur();
        $Arrive=$Offre->getLieuArrive();
        $Depart=$Offre->getLieuDepart();
        $Date=$Offre->getDateCol();
        //C:\Users\marwe\Documents\NetBeansProjects\FiThnitekMobile
        $chaine = "Prix:" . $Prix . "  Largeur: " . $Largeur . "Hauteur:" . $Hauteur ."Longueur:".$Longueur ."user:".$user."Arrive:".$Arrive."Depart:".$Depart."Date:".$Date;
        QRcode::png($chaine, "C:\Users\marwe\Documents\NetBeansProjects\FiThnitekMobile\QrAjouterOffre.png", "H", 20, 20);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Offre);
        return new JsonResponse($formatted);
    }
    public function myOffreAction(Request $request)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('FiThnitekBundle:OffreColis')
            ->findBy(array('idU'=>$request->get("id")));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function allOffreAction(Request $request)
    {

        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('FiThnitekBundle:OffreColis')
            ->MyOffre($request->get("id"));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function myReservationAction(Request $request)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('FiThnitekBundle:ReservationColis')
            ->findBy(array('idUR'=>$request->get("id")));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function trierAction(Request $request)
    {
        $em=$this->getDoctrine()->getRepository(OffreColis::class)->trierm($request->get("id"));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($em);
        return new JsonResponse($formatted);
    }
    public function trierprixAction(Request $request)
    {
        $em=$this->getDoctrine()->getRepository(OffreColis::class)->trieprix($request->get("id"));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($em);
        return new JsonResponse($formatted);
    }
    ////C:\Users\USER\Desktop\MOBILE\FiThnitekMobile
    public function rechercheDateMobileAction(Request $request)
    {
        $Date=$request->get('Date');
        $Prix=$request->get('prix');
        $em=$this->getDoctrine()->getManager()->getRepository(OffreColis::class)->findDate($Date,$Prix,$request->get("id"));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($em);
        return new JsonResponse($formatted);
    }
    public function supprimerOffreMobileAction(Request $request)
    {
        $supp=$this->getDoctrine()->getManager();
        $ids=$this->getDoctrine()->getRepository(OffreColis::class)->find($request->get("ids"));
        $supp->remove($ids);
        $supp->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ids);
        return new JsonResponse($formatted);
    }

    public function supprimerReserverMobileAction(Request $request)
    {
        $supp=$this->getDoctrine()->getManager();
        $ids=$this->getDoctrine()->getRepository(ReservationColis::class)->find($request->get("ids"));
        $hauteur = $ids->getLongueurResv();
        $largeur=$ids->getLargeurResv();
        $id=$ids->getIdReservationColis();
        $ido=$ids->getIdOffre();
        $Offre = $this->getDoctrine()->getRepository(OffreColis::class)->find($ido);
        $Offre->setLongueur($hauteur + $Offre->getLongueur() );
        $Offre->setLargeur($largeur + $Offre->getLargeur());
        $chaine = "Reservation d'id" .$id."longeur:" .  $hauteur ."largeur:".$largeur;
        //    $chaine = "mshet" ;
        QRcode::png($chaine, "C:\Users\marwe\Documents\NetBeansProjects\FiThnitekMobile\Reservationsupprimer.png", "H", 20, 20);
        $supp->persist($Offre);
        $supp->remove($ids);
        $supp->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ids);
        return new JsonResponse($formatted);
    }
    public function ajouterReservationMobileAction(Request $request)
    {
        $upd = $this->getDoctrine()->getManager();
        $Reservation = new ReservationColis();

        $Offre = $this->getDoctrine()->getRepository(OffreColis::class)->find($request->get("idcolis"));
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get("iduser"));

        $Prix = $Offre->getPrix();
        // $idU=$Offre->getIdU()->getUsername();
        $PrixOffre = $Reservation->getPrix();
        $hauteur = $Offre->getHauteur();
        $largeur = $Offre->getLargeur();
        $longueur = $Offre->getlongueur();
        $Reservation->setIdOffre($Offre);
        $Reservation->setIdUR($user);
        $Reservation->setHauteurResv($request->get('Hauteur'));
        $Reservation->setLargeurResv($request->get('Largeur'));
        $Reservation->setLongueurResv($request->get('Longueur'));

        $Reservation->setPrix($request->get('Longueur') *$request->get('Hauteur') * $request->get('Largeur') * $Prix);
        $Offre->setLongueur($longueur - $request->get('Longueur'));
        $Offre->setLargeur($largeur - $request->get('Largeur'));
        $m = $request->get('Largeur');
        $Hauteur = $request->get('Hauteur');
        $Longeur=$request->get('Longueur');
        $PrixOffre = $Reservation->getPrix();
        $chaine = "Prix d'offre:" . $Prix . "  Largeur: " . $m . "Hauteur:" . $Hauteur ."Longueur: ".$Longeur."prix Reservation:".$PrixOffre."..user:" .$user;
        QRcode::png($chaine,"C:\Users\marwe\Documents\NetBeansProjects\FiThnitekMobile\Reservation.png", "H", 20, 20);
        $upd->persist($Reservation);
        $upd->persist($Offre);
        $upd->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Reservation);
        return new JsonResponse($formatted);

    }


}