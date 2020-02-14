<?php

namespace FiThnitekBundle\Controller;

use FiThnitekBundle\Entity\DemandeTaxi;

use FiThnitekBundle\Entity\ReservationTaxi;
use FiThnitekBundle\Entity\reservationTaxis;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaxiController extends Controller
{
//////////////         FRONT                //////////////////////////////////////////////////

    public function affichedemandeAction()
    {
        $em = $this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->findAll();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $image=$user->getImage();
        return $this->render('@FiThnitek/FiThnitek/affichedemande.html.twig', array('a' => $em,'b'=>$image));
    }

    public function affichedemandeuserAction()
    {    $user = $this->container->get('security.token_storage')->getToken()->getUser();
          $id=$user->getId();
        $em = $this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->findBy(array('iduser'=>$id));


        return $this->render('@FiThnitek/FiThnitek/affichagedemandeuser.html.twig', array('a' => $em));
    }

    public function affichereservationAction()
    {           $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id=$user->getId();

        $em = $this->getDoctrine()->getManager()->getRepository(reservationTaxis::class)->findBy(array('iduser'=>$id));

        return $this->render('@FiThnitek/FiThnitek/afficherreservation.html.twig',array('a'=>$em));
    }


    public function logAction()
    {

        return $this->render('@FOSUser/Registration/register.html.twig');
    }



    public function ajouterdemandeAction(Request $request)
    {    $em=$this->getDoctrine()->getManager();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $demande = new DemandeTaxi();
        if ($request->isMethod('POST')) {
            $demande->setIduser( $user);
            $demande->setLieudarrive($request->get('lieua'));
            $demande->setLieudedepart($request->get('lieud'));
            $demande->setPeriode($request->get('periode'));
            $demande->setEtat(0);
            $demande->setPrix(0);
            $em->persist($demande);

            $em->flush();
            return $this->redirectToRoute("fi_thnitek_affichedemande") ;
        }

        return $this->render('@FiThnitek/FiThnitek/ajouterdemande.html.twig' , array('demande'=> $demande));
    }

   public function supprimerAction($id)
   {$em=$this->getDoctrine()->getRepository(DemandeTaxi::class)->find($id);
   $demande=$this->getDoctrine()->getManager();
   $demande->remove($em);
   $demande->flush();
       //$emm=$this->getDoctrine()->getRepo
       //sitory(DemandeTaxi::class)->findAll();
       return $this->redirectToRoute("fi_thnitek_affichedemandeuser") ;
   }

    public function supprimerresAction($id)
    {$em=$this->getDoctrine()->getRepository(reservationTaxis::class)->find($id);
        $demande=$this->getDoctrine()->getManager();
        $demande->remove($em);
        $demande->flush();
       // $emm=$this->getDoctrine()->getRepository(reservationTaxis::class)->findAll();
        return $this->redirectToRoute("fi_thnitek_affichereservation") ;
    }


    public function modifierAction($id ,Request $request)
    { $em=$this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $demande=$em->getRepository(DemandeTaxi::class)->find($id);
    if($request->isMethod('POST'))
    {
        $demande->setIduser( $user);
        $demande->setLieudarrive($request->get('lieua'));
        $demande->setLieudedepart($request->get('lieud'));
        $demande->setPeriode($request->get('periode'));


        $em->flush();
        return $this->redirectToRoute("fi_thnitek_affichedemandeuser");
    }
        return $this->render('@FiThnitek/FiThnitek/modifierdemande.html.twig' , array('demande'=> $demande));
    }

    public function reserverAction(Request $request,$id)
    {    $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $idd=$user->getId();


        $reservation = new reservationTaxis();
        $em=$this->getDoctrine()->getManager();
        $emm=$this->getDoctrine()->getManager();

        $demande=$this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->find($id);
        if($request->isMethod('POST'))
        {
            $reservation->setIduser($user);
            $demande->setEtat(1);

            $reservation->setIddemande($demande);
            $emm->persist($demande);
            $em->persist($reservation);
            $em->flush();
            $emm->flush();

            return $this->redirectToRoute("fi_thnitek_affichereservation") ;

        }





    }
 //////////////////// BACK        /////////////////////////////////////////


    public function affichedemandeBAction()
    {
        $em = $this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->findAll();

        return $this->render('@FiThnitek/FiThnitekBack/afficherdemande.html.twig', array('a' => $em));
    }



    public function ajouterdemandeBAction(Request $request)
    {    $em=$this->getDoctrine()->getManager();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $demande = new DemandeTaxi();
        if ($request->isMethod('POST')) {
            $demande->setIduser( $user);
            $demande->setLieudarrive($request->get('lieua'));
            $demande->setLieudedepart($request->get('lieud'));
            $demande->setPeriode($request->get('periode'));
            $demande->setEtat(0);
            $demande->setPrix(0);
            $em->persist($demande);

            $em->flush();
            return $this->redirectToRoute("fi_thnitek_affichedemandeB") ;
        }

        return $this->render('@FiThnitek/FiThnitekBack/ajouterdemande.html.twig' , array('demande'=> $demande));
    }

    public function affichereservationBAction()
    {           $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id=$user->getId();

        $em = $this->getDoctrine()->getManager()->getRepository(reservationTaxis::class)->findAll();

        return $this->render('@FiThnitek/FiThnitekBack/affichereservation.html.twig',array('a'=>$em));
    }

    public function supprimerresBAction($id)
    {$em=$this->getDoctrine()->getRepository(reservationTaxis::class)->find($id);
        $demande=$this->getDoctrine()->getManager();
        $demande->remove($em);
        $demande->flush();
        // $emm=$this->getDoctrine()->getRepository(reservationTaxis::class)->findAll();
        return $this->redirectToRoute("fi_thnitek_affichereservationB") ;
    }



    public function supprimerBAction($id)
    {$em=$this->getDoctrine()->getRepository(DemandeTaxi::class)->find($id);
        $demande=$this->getDoctrine()->getManager();
        $demande->remove($em);
        $demande->flush();
        //$emm=$this->getDoctrine()->getRepo
        //sitory(DemandeTaxi::class)->findAll();
        return $this->redirectToRoute("fi_thnitek_affichedemandeB") ;
    }



    public function reserverBAction(Request $request,$id)
    {    $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $idd=$user->getId();


        $reservation = new reservationTaxis();
        $em=$this->getDoctrine()->getManager();
        $emm=$this->getDoctrine()->getManager();

        $demande=$this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->find($id);
        if($request->isMethod('POST'))
        {
            $reservation->setIduser($user);
            $demande->setEtat(1);

            $reservation->setIddemande($demande);
            $emm->persist($demande);
            $em->persist($reservation);
            $em->flush();
            $emm->flush();

            return $this->redirectToRoute("fi_thnitek_affichereservationB") ;

        }

    }

    public function modifierBAction($id ,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $demande = $em->getRepository(DemandeTaxi::class)->find($id);
        if ($request->isMethod('POST')) {
            $demande->setIduser($user);
            $demande->setLieudarrive($request->get('lieua'));
            $demande->setLieudedepart($request->get('lieud'));
            $demande->setPeriode($request->get('periode'));


            $em->flush();
             return $this->redirectToRoute("fi_thnitek_affichedemandeB");
        }
        return $this->render('@FiThnitek/FiThnitekBack/modifierdemande.html.twig', array('demande' => $demande));

    }

    }