<?php

namespace FiThnitekBundle\Controller;

use FiThnitekBundle\Entity\OffreColis;
use FiThnitekBundle\Entity\ReservationColis;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $upd=$this->getDoctrine()->getManager();
        $Offre=new OffreColis();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($request->isMethod('POST'))
        {
            $Offre->setIdU($user);
            $Offre->setLieuDepart($request->get('Depart'));
            $Offre->setDateCol($request->get('Date'));
            $Offre->setHauteur($request->get('Hauteur'));
            $Offre->setLargeur($request->get('Largeur'));
            $Offre->setVoiture($request->get('Modele'));
            $Offre->setLieuArrive($request->get('Arrive'));
            $Offre->setPrix($request->get('Prix'));
            $upd->persist($Offre);
            $upd->flush();
            return $this->redirectToRoute("fi_thnitek_afficherOffre");
        }
        return $this->render('@FiThnitek/FiThnitek/OffreColis.html.twig',array('Offre'=> $Offre
        ));

    }
    public function afficherOffreAction()
    {
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
        $em=$this->getDoctrine()->getRepository(OffreColis::class)->findAll();
        return $this->render('@FiThnitek/FiThnitek/affichageallColis.html.twig',array('r'=>$em));
    }
    public function ajouterReservationAction(Request $request,$id)
    {
        $upd=$this->getDoctrine()->getManager();
        $Reservation=new ReservationColis();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $Offre=$this->getDoctrine()->getRepository(OffreColis::class)->find($id);

        if ($request->isMethod('POST'))
        {
            $Reservation->setIdOffre($Offre);
            $Reservation->setIdUR($user);
            $Reservation->setHauteurResv($request->get('Hauteur'));
            $Reservation->setLargeurResv($request->get('Largeur'));
            $Reservation->setPrix(5);
            $upd->persist($Reservation);
            $upd->flush();
            return$this->redirectToRoute("fi_thnitek_affichageReservation");
          //  return $this->render('@FiThnitek/FiThnitek/login.html.twig',array('r'=> $Reservation));
        }
        return $this->render('@FiThnitek/FiThnitek/register.html.twig');

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
        $supp->remove($ids);
        $supp->flush();
        return $this->redirectToRoute('fi_thnitek_affichageReservation');
    }
////////////////////////////////Back///////////////////////////////////////////////////
    public function afficherOffrebackAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em=$this->getDoctrine()->getRepository(OffreColis::class)->findAll();
        return $this->render('@FiThnitek/FiThnitek/affichageoffrecolisback.html.twig',array('r'=>$em));
    }
    public function ajouteroffrecolisbackAction(Request $request)
    {
        $upd=$this->getDoctrine()->getManager();
        $Offre=new OffreColis();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($request->isMethod('POST'))
        {
            $Offre->setIdU($user);
            $Offre->setLieuDepart($request->get('Depart'));
            $Offre->setDateCol($request->get('Date'));
            $Offre->setHauteur($request->get('Hauteur'));
            $Offre->setLargeur($request->get('Largeur'));
            $Offre->setVoiture($request->get('Modele'));
            $Offre->setLieuArrive($request->get('Arrive'));
            $Offre->setPrix($request->get('Prix'));
            $upd->persist($Offre);
            $upd->flush();
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

        if ($request->isMethod('POST'))
        {
            $Reservation->setIdOffre($Offre);
            $Reservation->setIdUR($user);
            $Reservation->setHauteurResv($request->get('Hauteur'));
            $Reservation->setLargeurResv($request->get('Largeur'));
            $Reservation->setPrix(5);
            $upd->persist($Reservation);
            $upd->flush();
            return $this->redirectToRoute('fi_thnitek_afficherOffreback');
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
        $supp->remove($ids);
        $supp->flush();
        return $this->redirectToRoute('fi_thnitek_affichageReservationback');
    }

}
