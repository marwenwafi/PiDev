<?php

namespace FiThnitekBundle\Controller;

use AppBundle\Entity\User;
use FiThnitekBundle\Entity\offreCovoiturage;
use FiThnitekBundle\Entity\ReservationCovoiturage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle ;
class CovoiturageController extends Controller
{

///////////////Ajouter offre covoiturage /////////////////////////////////
    public function ajoutoffrecovoiturageAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $cov = new offreCovoiturage();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $datesys = new \DateTime();
        $dateesys= $datesys->format('Y-m-d');
        $emailuser = $this->getUser()->getEmail();
        if ($request->isMethod('POST'))
        {
                if($dateesys < ($request->get('datee')))
                {$text = "you just made a carpool offer,here are the details of this offer"."Destination : ".$request->get('destination')
            ."Departure : ".$request->get('departure')."Date".$request->get('datee')."Price".$request->get('prix')."Number of places".$request->get('nbr')
                ;
                    $message = \Swift_Message::newInstance()->setSubject('Your CarSharing Offer')->setFrom('fithnitekcodeslayers@gmail.com')
                    ->setTo($emailuser)->setBody($text);
                    $this->get('mailer')->send($message);
                    $cov->setIdutilisateur($user);
                    $cov->setDestination($request->get('destination'));
                    $cov->setDepart($request->get('departure'));
                    $cov->setPrix($request->get('prix'));
                    $cov->setNbrplaceo($request->get('nbr'));
                    $cov->setDate($request->get('datee'));
                    $cov->setVoiture($request->get('car'));
                    $em->persist($cov);
                    $em->flush();
                    //return $this->render('@FiThnitek/FiThnitek/offrecovoiturage.html.twig', array('cov' => $cov));
                //    return $this->redirectToRoute("fi_thnitek_ajoutcovoiturageutilisateur");
                    return $this->redirectToRoute("fi_thnitek_affichcovoiturageutilisateur");
                }
                else
                    {
                        return $this->redirectToRoute("fi_thnitek_ajoutcovoiturageutilisateur");
                    }
        }
        return $this->render('@FiThnitek/FiThnitek/offrecovoiturage.html.twig', array('cov' => $cov));
    }
/////////////////////////// Afficher offre faite par l'utilisateur////////////////////////////////////
    public function readoffreAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        //var_dump($user);
        $em = $this->getDoctrine()->getManager()->getRepository(offreCovoiturage::class)->findBy(array('idutilisateur'=>$user->getId()));
        return $this->render('@FiThnitek/FiThnitek/affichagecovoiturageutilisateur.html.twig', array('r' => $em,'user'=>$user));
    }
//////////////////////////// Supprimer une offre //////////////////////////////////////////
    public function supprimeroffreAction($id)
    {

        $ids = $this->getDoctrine()->getRepository(offreCovoiturage::class)->find($id);

        $res = $this->getDoctrine()->getRepository(ReservationCovoiturage::class)->findBy(array("idoffrer"=>$id));

        if($res == NULL )
            {

    $em = $this->getDoctrine()->getManager();
    $em->remove($ids);
    $em->flush();
            }
//$tab = $this->getDoctrine()->getRepository(Club::class)->findAll() ;

        return $this->redirectToRoute("fi_thnitek_affichcovoiturageutilisateur",array('count'=>$res));
    }
///////////////////////////// modifier une offre de covoiturage /////////////////////////
    public function modifieroffrecovoiturageAction(Request $request, $id)
    {   $res = $this->getDoctrine()->getRepository(ReservationCovoiturage::class)->findBy(array("idoffrer"=>$id));
        $em = $this->getDoctrine()->getManager();
        $cov = $em->getRepository(offreCovoiturage::class)->find($id);
        $dest=$cov->getDestination();
        $dep = $cov->getDepart();
        $onbr = $cov->getNbrplaceo();
        $oprix = $cov->getPrix();
        $datesys = new \DateTime();
        $dateesys= $datesys->format('Y-m-d');
        $emailuser = $this->getUser()->getEmail();
        //$cov = new offreCovoiturage();
        //$user = $this->container->get('security.token_storage')->getToken()->getUser();
        //dump($user);
       if ($res == NULL)
       {
           if ($request->isMethod('POST')) {
               if($dateesys < ($request->get('datee')))
               {$text = "you just update your carpool offer,here are the details of this offer"."Old Destination : ".
                   $dest."New Destination ".$request->get('destination')."Old Departure".$dep
                   ."New Departure : ".$request->get('departure')."Date".$request->get('datee')."Price".$request->get('prix')."Number of places".$request->get('nbr')
               ;
                   $message = \Swift_Message::newInstance()->setSubject('Your CarSharing Update')->setFrom('fithnitekcodeslayers@gmail.com')
                       ->setTo($emailuser)->setBody($text);
                   $this->get('mailer')->send($message);
                   $cov->setDestination($request->get('destination'));
                   $cov->setDepart($request->get('departure'));
                   $cov->setPrix($request->get('prix'));
                   $cov->setNbrplaceo($request->get('nbr'));
                   $cov->setDate($request->get('datee'));
                   $cov->setVoiture($request->get('car'));
                   //$em->persist($cov);
                   $em->flush();
                   // return $this->render('@FiThnitek/FiThnitek/modifieroffrecovoiturage.html.twig', array('cov' => $cov));
                   return $this->redirectToRoute("fi_thnitek_affichcovoiturageutilisateur");
               }

               else
               {
                   return $this->render('@FiThnitek/FiThnitek/modifieroffrecovoiturage.html.twig', array('cov' => $cov));
               }
       }
       }
       else
       {
           return $this->redirectToRoute("fi_thnitek_affichcovoiturageutilisateur");
       }
        return $this->render('@FiThnitek/FiThnitek/modifieroffrecovoiturage.html.twig', array('cov' => $cov));

    }
///////////////////////////////Afficher toute les offres ////////////////////////////////
    public function afficheallAction()
    {   $datesys = new \DateTime();
        $datea= $datesys->format('Y-m-d');
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $idu = $user->getId();
        $em = $this->getDoctrine()->getManager()->getRepository(offreCovoiturage::class);
        $cov = $em->myfindoffre($idu,$datea);

        return $this->render('@FiThnitek/FiThnitek/affichageallcovoiturage.html.twig', array('cov' => $cov));
    }
///////////////////////////// Ajout une réservation ////////////////////////////////
    public function ajoutreservationAction(Request $request,$id)
    {
        $reservation = new ReservationCovoiturage();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $emailuser = $this->getUser()->getEmail();
        $username = $this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
      //  $cov = $em->getRepository(offreCovoiturage::class)->findAll();

        $offre= $this->getDoctrine()->getRepository(offreCovoiturage::class)->find($id);
        $nbrp = $offre->getNbrplaceo();
        $prix = $offre->getPrix();
        $dest = $offre->getDestination();
        $usero = $offre->getIdutilisateur();
        $userkbir= $this->getDoctrine()->getRepository(User::class)->find($usero);
        $emailuser1=$userkbir->getEmail();
        if ($request->isMethod('POST'))
        { if ($nbrp < ($request->get('nbrr')))
        {
            return $this->redirectToRoute("fi_thnitek_afficheall");

            //return $this->redirectToRoute("fi_thnitek_readreservation");
        }
        else {

            $text = "Carsharing Reservation"."Destination : ".
                $dest."  Totalprice ".$prix*($request->get('nbrr'));
            ;
            $message = \Swift_Message::newInstance()->setSubject('Your CarSharing Reservation')->setFrom('fithnitekcodeslayers@gmail.com')
                ->setTo($emailuser)->setBody($text);
            $this->get('mailer')->send($message);
            $text2 = "the user".$username."has reserved ".$request->get('nbrr')."places";
            $message2= \Swift_Message::newInstance()->setSubject("Carsharing Reservation")->setFrom('fithnitekcodeslayers@gmail.com')->setTo($emailuser1)
                ->setBody($text2);
            $this->get('mailer')->send($message2);
                $reservation->setIdutilisateurr($user);
                $reservation->setIdoffrer($offre);
                $reservation->setNbrplacer($request->get('nbrr'));
                $reservation->setPrixt($prix*($request->get('nbrr')));

                $offre->setNbrplaceo($nbrp - ($request->get('nbrr')));
                $em->persist($reservation);
                $em->flush();

            return $this->redirectToRoute("fi_thnitek_readreservation");
            }
           // return $this->redirectToRoute("fi_thnitek_readreservation");

        }


       return $this->redirectToRoute("fi_thnitek_afficheall");

    }
////////////////////////Afficher reservation de l'utilisateur ///////////////////////////////
    public function readreserverAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager()->getRepository(ReservationCovoiturage::class)->findBy(array('idutilisateurr'=>$user->getId()));
        return $this->render('@FiThnitek/FiThnitek/affichagereservecovoiturageutilisateur.html.twig', array('r' => $em,'user'=>$user));
    }
////////////////////////Supprimer une reservation de covoiturage ///////////////////////////////////
    public function supprimerrescovAction($id)
    {$user = $this->container->get('security.token_storage')->getToken()->getUser();
        $ids = $this->getDoctrine()->getRepository(ReservationCovoiturage::class)->find($id);
        $ido = $ids->getIdoffrer();
        $offre = $this->getDoctrine()->getRepository(offreCovoiturage::class)->find($ido);
        $iduo = $offre->getIdutilisateur();
        $userkbir = $this->getDoctrine()->getRepository(User::class)->find($iduo);
        $mailuser1=$userkbir->getEmail();
        $username =$this->getUser()->getUsername();
        $dateo = $offre->getDate();
        $datesys = new \DateTime();
        $datea= $datesys->format('Y-m-d');

        if ($dateo > $datea)
        {   $text = "The user ".$username."canceled his reservation";
            $offre->setNbrplaceo($offre->getNbrplaceo()+$ids->getNbrplacer());
            $message = \Swift_Message::newInstance()->setSubject('Your CarSharing Reservation')->setFrom('fithnitekcodeslayers@gmail.com')
                ->setTo($mailuser1)->setBody($text);
            $this->get('mailer')->send($message);
            $em = $this->getDoctrine()->getManager();
            $em->remove($ids);
            $em->flush();
            return $this->redirectToRoute("fi_thnitek_readreservation");
        }

else {


    $em = $this->getDoctrine()->getManager();
    $em->remove($ids);
    $em->flush();
    return $this->redirectToRoute("fi_thnitek_readreservation");

}

        //$tab = $this->getDoctrine()->getRepository(Club::class)->findAll() ;
       // return $this->redirectToRoute("fi_thnitek_readreservation");

    }
////////////////////////////  Recherche///////////
    public function recherchecovAction(Request $request)
    {
        if($request->isMethod("POST"))
        {
            $datesys = new \DateTime();
            $datea= $datesys->format('Y-m-d');
            if($datea < $request->get('daterecherche'))
                {
                    $user = $this->container->get('security.token_storage')->getToken()->getUser();
                    $idu = $user->getId();
                    $dater = $request->get('daterecherche');
                    $dest = $request->get('destinationrecherche') ;
                    $dept = $request->get('departrecherche');
                    $nbrplace = $request->get('nbrplacerecherche');
                    $em = $this ->getDoctrine()->getManager()->getRepository(offreCovoiturage::class);
                    $cov = $em->myrechercheoffre($nbrplace,$idu,$dater,$dest,$dept);
                    return $this->render('@FiThnitek/FiThnitek/affichageallcovoiturage.html.twig', array('cov' => $cov));
                }

        }




        return $this->redirectToRoute("fi_thnitek_afficheall");
    }
///////////////////////////////////////Ordonner lowel  //////////////////////////
    public function ordonneroffrecovAction()
    {   $datesys = new \DateTime();
        $datea= $datesys->format('Y-m-d');
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $idu = $user->getId();
        $em = $this->getDoctrine()->getManager()->getRepository(offreCovoiturage::class);
        $cov = $em->ordonnerkbiroffre($idu,$datea);
        //var_dump($datea);
        return $this->render('@FiThnitek/FiThnitek/affichageallcovoiturage.html.twig', array('cov' => $cov));
    }
////////////////////////////////Ordoner theni ////////////////////////
    public function ordonneroffrecov1Action()
    {   $datesys = new \DateTime();
        $datea= $datesys->format('Y-m-d');
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $idu = $user->getId();
        $em = $this->getDoctrine()->getManager()->getRepository(offreCovoiturage::class);
        $cov = $em->ordonnersghiroffre($idu,$datea);
        //var_dump($datea);
        return $this->render('@FiThnitek/FiThnitek/affichageallcovoiturage.html.twig', array('cov' => $cov));
    }
/////////////////////////////////Back////////////////////////////////////////////

    public function ajoutoffrecovbackAction(Request $request)
    {   $datesys = new \DateTime();
        $datea= $datesys->format('Y-m-d');
        $em = $this->getDoctrine()->getManager();
        $cov = new offreCovoiturage();
        //$user = $this->container->get('security.token_storage')->getToken()->getUser();
        $alluser=$this->getDoctrine()->getRepository(User::class)->findAll();

        //$user2 =$this->getDoctrine()->getRepository(User::class)->find($id);
        //dump($user);
        if ($request->isMethod('POST')) {
                if($datea< ($request->get('dateeback')))
                {$id = $request->get("iduser");
                $user = $this->getDoctrine()->getRepository(User::class)->find($id);
                $mailuser = $user->getEmail();
                    $text2 = "The Admin added your offer , They are the detailes of the offer :  Destination : "
                        .$request->get('destinationback');
                    $message2= \Swift_Message::newInstance()->setSubject("Carsharing offers")->setFrom('fithnitekcodeslayers@gmail.com')->setTo($mailuser)
                        ->setBody($text2);
                    $this->get('mailer')->send($message2);

                    $cov->setIdutilisateur($user);
                    $cov->setDestination($request->get('destinationback'));
                    $cov->setDepart($request->get('departureBack'));
                    $cov->setPrix($request->get('prixback'));
                    $cov->setNbrplaceo($request->get('nbrback'));
                    $cov->setDate($request->get('dateeback'));
                    $cov->setVoiture($request->get('carback'));
                    $em->persist($cov);
                    $em->flush();
                    return $this->redirectToRoute("fi_thnitek_affichagecovback");
                }
                else
                {
                    return $this->render('@FiThnitek/FiThnitek/ajoutcovoiturageback.html.twig', array('cov' => $alluser));
                }
        }
        return $this->render('@FiThnitek/FiThnitek/ajoutcovoiturageback.html.twig', array('cov' => $alluser));
    }

/////////Afficher all offers back ///////
    public function afficheallcovbackAction()
    {$em = $this->getDoctrine()->getManager()->getRepository(offreCovoiturage::class);
        $cov = $em->mytriedateadmin();

        return $this->render('@FiThnitek/FiThnitek/affichageoffrecovoiturageback.html.twig',array('cov'=>$cov));
    }
///////////////supprimer une offre back ////////////////////////
    public function supprimercovbackAction($id)
    { $res = $this->getDoctrine()->getRepository(ReservationCovoiturage::class)->findBy(array("idoffrer"=>$id));
    if ($res == NULL)
    {
        $ids = $this->getDoctrine()->getRepository(offreCovoiturage::class)->find($id);
        $iduo = $ids->getIdutilisateur();
        $userkbir = $this->getDoctrine()->getRepository(User::class)->find($iduo);
        $mailuser1=$userkbir->getEmail();
        $text2 = "The Admin has deleted your offer , They are the detailes of the offer Destination : "
            .$ids->getDestination();
        $message2= \Swift_Message::newInstance()->setSubject("Carsharing offers")->setFrom('fithnitekcodeslayers@gmail.com')->setTo($mailuser1)
            ->setBody($text2);
        $this->get('mailer')->send($message2);

        $em = $this->getDoctrine()->getManager();
        $em->remove($ids);
        $em->flush();
        //$tab = $this->getDoctrine()->getRepository(Club::class)->findAll() ;
    }



        return $this->redirectToRoute("fi_thnitek_affichagecovback");
    }
    public function modifiercovbackAction(Request $request, $id)
    { $res = $this->getDoctrine()->getRepository(ReservationCovoiturage::class)->findBy(array("idoffrer"=>$id));
    if($res == NULL)
    {
        $datesys = new \DateTime();
        $dateesys= $datesys->format('Y-m-d');
        $em = $this->getDoctrine()->getManager();
        $cov = $em->getRepository(offreCovoiturage::class)->find($id);
        $iduo = $cov->getIdutilisateur();
        $userkbir = $this->getDoctrine()->getRepository(User::class)->find($iduo);
        $mailuser1=$userkbir->getEmail();
        //$cov = new offreCovoiturage();
        //$user = $this->container->get('security.token_storage')->getToken()->getUser();
        //dump($user);
        if ($request->isMethod('POST')) {

            if($dateesys < ($request->get('dateeback')))
            {
                $text="The admin has updated your offer : "."  Old Destination ".$cov->getDestination()."New Destination ".$request->get('destinationback');
                $message = \Swift_Message::newInstance()->setSubject('Your CarSharing Offer')->setFrom('fithnitekcodeslayers@gmail.com')
                    ->setTo($mailuser1)->setBody($text);
                $this->get('mailer')->send($message);
                $cov->setDestination($request->get('destinationback'));
                $cov->setDepart($request->get('departureBack'));
                $cov->setPrix($request->get('prixback'));
                $cov->setNbrplaceo($request->get('nbrback'));
                $cov->setDate($request->get('dateeback'));
                $cov->setVoiture($request->get('carback'));
                //$em->persist($cov);
                $em->flush();
                return $this->redirectToRoute("fi_thnitek_affichagecovback");
            }
else {
    return $this->render('@FiThnitek/FiThnitek/modifiercovoiturageback.html.twig', array('cov' => $cov));
}


        }
    }

    else
        {
        return $this->redirectToRoute("fi_thnitek_affichagecovback");
    }

        return $this->render('@FiThnitek/FiThnitek/modifiercovoiturageback.html.twig', array('cov' => $cov));
    }
//////////////////////////////Reservation Offre Back ///////////////////////////////
    public function ajoutreservationBackAction(Request $request,$id)
    {
        $reservation = new ReservationCovoiturage();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        //  $cov = $em->getRepository(offreCovoiturage::class)->findAll();

        $offre= $this->getDoctrine()->getRepository(offreCovoiturage::class)->find($id);
        $nbrpd =$offre->getNbrplaceo();
        if($nbrpd != 0 )
            {
                if ($request->isMethod('POST'))
                {
                    $reservation->setIdutilisateurr($user);
                    $reservation->setIdoffrer($offre);
                    $reservation->setNbrplacer($request->get('nbrrback'));
                    $reservation->setPrixt($offre->getPrix()*($request->get('nbrrback')));
                    $offre->setNbrplaceo($nbrpd-($request->get('nbrrback')));
                    $em->persist($reservation);
                    $em->flush();
             return $this->redirectToRoute("fi_thnitek_affichageresevcovback");
                }
            }
        else
            {
            return $this->redirectToRoute("fi_thnitek_affichagecovback");
            }

    }
    public function afficheallreservationBackAction()
    {$em = $this->getDoctrine()->getManager();
        $cov = $em->getRepository(ReservationCovoiturage::class)->findAll();

        return $this->render('@FiThnitek/FiThnitek/affichagereservcovoiturageback.html.twig', array('cov' => $cov));
    }
 ///////////////////////////////Supprimer reservation cov ////////////////////////////////////////////////
    public function supprimerrescovbackAction($id)
    {
        $ids = $this->getDoctrine()->getRepository(ReservationCovoiturage::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($ids);
        $em->flush();
        //$tab = $this->getDoctrine()->getRepository(Club::class)->findAll() ;

        return $this->redirectToRoute("fi_thnitek_affichageresevcovback");
    }
////////////////////RechercheBack////////////////////////////////
 public function  recherchecovBackAction(Request $request)
    {
        if($request->isMethod("POST"))
        {
            //$datesys = new \DateTime();
            //$datea= $datesys->format('Y-m-d');
            //$user = $this->container->get('security.token_storage')->getToken()->getUser();
            //$idu = $user->getId();
            $datea = $request->get('daterechercheback');
            $dest = $request->get('destinationrechercheback') ;
            $dept = $request->get('departrechercheback');
            $nbrplace = $request->get('nbrplacerechercheback');
            $em = $this ->getDoctrine()->getManager()->getRepository(offreCovoiturage::class);
            $cov = $em->myrecherchBackeoffre($nbrplace,$datea,$dest,$dept);
            return $this->render('@FiThnitek/FiThnitek/affichageoffrecovoiturageback.html.twig', array('cov' => $cov));
        }




        return $this->redirectToRoute("fi_thnitek_afficheall");

    }
////////////////////Utilisateurfind /////////////////////////
public function utilisateurcovbackfindAction(Request $request,$id)
            {
                $user = $this->getDoctrine()->getRepository(User::class)->find($id);


                return $this->render('@FiThnitek/FiThnitek/affichageutilisateuroffcovoiturageback.html.twig', array('user' => $user));
            }
}
