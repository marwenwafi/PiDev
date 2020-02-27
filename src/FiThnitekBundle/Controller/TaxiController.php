<?php

namespace FiThnitekBundle\Controller;

use AppBundle\Entity\User;
use FiThnitekBundle\Entity\DemandeTaxi;


use FiThnitekBundle\Entity\Notification;
use FiThnitekBundle\Entity\reservationTaxis;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class TaxiController extends Controller
{
//////////////         FRONT                //////////////////////////////////////////////////

    public function affichedemandeAction(Request $request)
    {/*
        $date=new \DateTime();

        $daten=$date->format(' H:i');
        dump($daten);
        $em = $this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->affichagedemande();
        $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
        return $this->render('@FiThnitek/FiThnitek/affichedemande.html.twig', array('a' => $em , 'b'=>$emm ));

*/         $datek=new \DateTime();

        $now=$datek->format(' Y-m-d');
        if($request->isMethod('POST'))
        {  $region=$request->get('region');
           $date=$request->get('date');
            if ($date==$now)
            {
                $em=$this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->region($region,$date);
                $user = $this->container->get('security.token_storage')->getToken()->getUser();
                $id=$user->getId();

                $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->count($id);
                return $this->render('@FiThnitek/FiThnitek/affichedemande.html.twig', array('a' => $em , 'b'=>$emm,'user'=>$user));
            }
            else if ($date > $now)
            {
                $em=$this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->region2($region,$date);
                $user = $this->container->get('security.token_storage')->getToken()->getUser();
                $id=$user->getId();

                $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->count($id);
                return $this->render('@FiThnitek/FiThnitek/affichedemande.html.twig', array('a' => $em , 'b'=>$emm ,'user'=>$user));
            }
        }
        else
        {
            $em = $this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->affichagedemande();
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id=$user->getId();


            $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->count($id);
            return $this->render('@FiThnitek/FiThnitek/affichedemande.html.twig', array('a' => $em , 'b'=>$emm,'user'=>$user));

        }







    }
    /*///////////////////////////////////////////////////////////////////////////
    public function regionAction(Request $request)
    {
        if($request->isMethod('POST'))
        {  $region=$request->get('region');
            $em=$this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->region($region);
            $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
            return $this->render('@FiThnitek/FiThnitek/rechercheregion.html.twig', array('a' => $em , 'b'=>$emm));
        }
     else
     {
         $em = $this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->affichagedemande();
         $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
         return $this->render('@FiThnitek/FiThnitek/affichedemande.html.twig', array('a' => $em , 'b'=>$emm));

     }


    }
//////////////////////////////////////////////////////////*/
    public function TrierAction( )
    {

            $em=$this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->triprix();
            $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
            return $this->render('@FiThnitek/FiThnitek/affichedemande.html.twig', array('a' => $em , 'b'=>$emm));


    }
    public function TrierHAction()
    {

        $em=$this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->trihour();
        $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
        return $this->render('@FiThnitek/FiThnitek/affichedemande.html.twig', array('a' => $em , 'b'=>$emm));


    }
    public function notifdemandeAction($title)
    { $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id=$user->getId();
        $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->count($id);
        $demande=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trie($id,$title);

        $t1='Modifier Demande Taxi';
        $t2='Supprimer Demande Taxi';

        $mod=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trie($id,$t1);
        $sup=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trie($id,$t2);
        return $this->render('@FiThnitek/FiThnitek/notifAjout.html.twig', array( 'b'=>$emm ,'user'=>$user,'s'=>$demande ,'s'=> $demande , 'mod'=> $mod,'sup'=> $sup) );


    }
    public function showdemandeAction($article)

    { $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id=$user->getId();
        //var_dump($idd);
        $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->count($id);
      $a=$this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->find($article);
       $t='Demande Taxi';

        $t1='Modifier Demande Taxi';
        $t2='Supprimer Demande Taxi';
        $demande=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trie($id,$t);
        $mod=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trie($id,$t1);
        $sup=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trie($id,$t2);
        return $this->render('@FiThnitek/FiThnitek/show.html.twig', array('a'=>$a, 'b'=>$emm ,'user'=>$user,'s'=> $demande , 'mod'=> $mod,'sup'=> $sup) );


    }


    public function affichedemandeuserAction()
    {    $user = $this->container->get('security.token_storage')->getToken()->getUser();
          $id=$user->getId();
        $em = $this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->findBy(array('iduser'=>$id));
        $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->count($id);
        $t='Demande Taxi';
        $t1='Modifier Demande Taxi';
        $t2='Supprimer Demande Taxi';
        $demande=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trie($id,$t);
        $mod=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trie($id,$t1);
        $sup=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trie($id,$t2);
        return $this->render('@FiThnitek/FiThnitek/affichagedemandeuser.html.twig', array('a' => $em, 'user'=>$user,'b'=>$emm, 's'=> $demande , 'mod'=> $mod,'sup'=> $sup));
    }

    public function affichereservationAction()
    {          $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id=$user->getId();

        $em = $this->getDoctrine()->getManager()->getRepository(reservationTaxis::class)->findBy(array('iduser'=>$id));
       $t='Chauffeur';

        $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->trief($t,$id);

        return $this->render('@FiThnitek/FiThnitek/afficherreservation.html.twig',array('a'=>$em,'user'=>$user, 'b'=>$emm));
    }


    public function logAction()
    {

        return $this->render('@FOSUser/Registration/register.html.twig');
    }



    public function ajouterdemandeAction(Request $request)
    {    $em=$this->getDoctrine()->getManager();
        $date=new \DateTime();

        $daten=$date->format('Y-m-d');
        $dateh=$date->format('H:m');

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id=$user->getId();

        $demande = new DemandeTaxi();
        if ($request->isMethod('POST')) {
            if($request->get('date') == $daten  and $request->get('periode') > $dateh )
            {
                $demande->setIduser( $user);
                $demande->setLieudarrive($request->get('lieua'));
                $demande->setLieudedepart($request->get('lieud'));

                $demande->setPeriode($request->get('periode'));
                $demande->setDateD($request->get('date'));
                $demande->setRegion($request->get('region'));
                $demande->setEtat(0);
                $demande->setPrix(20);
                $em->persist($demande);
                $em->flush();
                //////  DEBUT NOTIFICATION //////

                $notification= new Notification();
                $notification
                    ->setTitle('Demande Taxi')
                    ->setDescription('Ajout de demande de taxi realisé avec succés')
                    ->setRoute('fi_thnitek_affichedemandeuser')
                    ->setParameters(array('id'=>$demande->getId()))
                    ->setType('Client')
                   ->setIduser($user)



                ;
                $notification->setIdarticle($demande);
                $notification->setIduser($user);
                $em->persist($notification);

                $em->flush();
                $pusher = $this->get('mrad.pusher.notificaitons');
                $pusher->trigger($notification);
                ///// FIN NOTIFICATION //////


                return $this->redirectToRoute("fi_thnitek_affichedemande") ;
            }
            else if($request->get('date') > $daten   )
            {
                $demande->setIduser($user);
                $demande->setLieudarrive($request->get('lieua'));
                $demande->setLieudedepart($request->get('lieud'));

                $demande->setPeriode($request->get('periode'));
                $demande->setDateD($request->get('date'));
                $demande->setRegion($request->get('region'));
                $demande->setEtat(0);
                $demande->setPrix(20);
                $em->persist($demande);
                $em->flush();
                //////  DEBUT NOTIFICATION //////

                $notification= new Notification();
                $notification
                    ->setTitle('Demande Taxi')
                    ->setDescription('vous avez fait une demande de taxi ')
                    ->setRoute('fi_thnitek_affichedemandeuser')
                    ->setParameters(array('id'=>$demande->getId()))
                    ->setType('Client')
                   // ->setIduser($user)




                ;
                $notification->setIduser($user);
                $notification->setIdarticle($demande);
                //var_dump($demande->getId());

                $em->persist($notification);

                $em->flush();
                $pusher = $this->get('mrad.pusher.notificaitons');
                $pusher->trigger($notification);
                ///// FIN NOTIFICATION //////


                return $this->redirectToRoute("fi_thnitek_affichedemande") ;
            }

        }
        $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->count($id);
        return $this->render('@FiThnitek/FiThnitek/ajouterdemande.html.twig' , array('demande'=> $demande, 'user'=>$user,'b'=>$emm));
    }

   public function supprimerAction($id)
   {$em=$this->getDoctrine()->getRepository(DemandeTaxi::class)->find($id);
   $sou=$em->getId();
       $user = $this->container->get('security.token_storage')->getToken()->getUser();
       $idu=$user->getId();
   $notid=$this->getDoctrine()->getRepository(Notification::class)->supp($idu,$id);

   $demande=$this->getDoctrine()->getManager();
       $demande01=$this->getDoctrine()->getManager();
   /*////////////// notif ///////////////////////////
       $user = $this->container->get('security.token_storage')->getToken()->getUser();
       $notification= new Notification();
       $notification
           ->setTitle('Supprimer Demande Taxi')
           ->setDescription('a supprime sa demande de taxi ')
           ->setRoute('fi_thnitek_affichedemandeuser')
           ->setParameters(array('id'=>$em->getId()))
           ->setIduser($user)


       ;
       $notification->setIdarticle($demande);

       $s=$this->getDoctrine()->getManager();
       $s->persist($notification);

       $s->flush();
       $pusher = $this->get('mrad.pusher.notificaitons');
       $pusher->trigger($notification);
   ////////Notif     //*/
   $demande01->remove($em);
   $demande01->flush();


       //$emm=$this->getDoctrine()->getRepo
       //sitory(DemandeTaxi::class)->findAll();
       return $this->redirectToRoute("fi_thnitek_affichedemandeuser") ;
   }

    public function supprimerresAction($id)
    {$em=$this->getDoctrine()->getRepository(reservationTaxis::class)->find($id);
        $demande=$this->getDoctrine()->getManager();
        $demande->remove($em);
        $demande->flush();
        $iddemande=$em->getIddemande();
        $de=$this->getDoctrine()->getRepository(DemandeTaxi::class)->find($iddemande);
        $de->setEtat(0);
        $demande->persist($de);
        $demande->flush();


       // $emm=$this->getDoctrine()->getRepository(reservationTaxis::class)->findAll();
        return $this->redirectToRoute("fi_thnitek_affichereservation") ;
    }


    public function modifierAction($id ,Request $request)
    { $em=$this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $demande=$em->getRepository(DemandeTaxi::class)->find($id);
        $date=new \DateTime();

        $daten=$date->format('Y-m-d');
        $dateh=$date->format('H:m');
    if($request->isMethod('POST'))
    {  if($request->get('date') == $daten  and $request->get('periode') > $dateh )
    {
        $demande->setIduser( $user);
        $demande->setregion($request->get('region'));
        $demande->setLieudarrive($request->get('lieua'));
        $demande->setLieudedepart($request->get('lieud'));
        $demande->setPeriode($request->get('periode'));
        $demande->setdateD($request->get('date'));

        $em->flush();
        //////  DEBUT NOTIFICATION //////

        $notification= new Notification();
        $notification
            ->setTitle('Modifier Demande Taxi')
            ->setDescription('vous avez modifier une demande de taxi ')
            ->setRoute('fi_thnitek_affichedemandeuser')
            ->setParameters(array('id'=>$demande->getId()))
            ->setIduser($user)
            ->setType('Client')


        ;
        $notification->setIdarticle($demande);

        $em->persist($notification);

        $em->flush();
        $pusher = $this->get('mrad.pusher.notificaitons');
        $pusher->trigger($notification);
        ///// FIN NOTIFICATION //////
        return $this->redirectToRoute("fi_thnitek_affichedemandeuser");
    }
    else if($request->get('date') > $daten )
    {
        $demande->setIduser( $user);
        $demande->setregion($request->get('region'));
        $demande->setLieudarrive($request->get('lieua'));
        $demande->setLieudedepart($request->get('lieud'));
        $demande->setPeriode($request->get('periode'));
        $demande->setdateD($request->get('date'));

        $em->flush();
        //////  DEBUT NOTIFICATION //////

        $notification= new Notification();
        $notification
            ->setTitle('Modifier Demande Taxi')
            ->setDescription('vous avez modifier une demande de taxi ')
            ->setRoute('fi_thnitek_affichedemandeuser')
            ->setParameters(array('id'=>$demande->getId()))
            ->setIduser($user)



        ;
        $notification->setIdarticle($demande);
        $notification->setType('Client');
        $em->persist($notification);

        $em->flush();
        $pusher = $this->get('mrad.pusher.notificaitons');
        $pusher->trigger($notification);
        ///// FIN NOTIFICATION //////
        return $this->redirectToRoute("fi_thnitek_affichedemandeuser");
    }
    }
        return $this->render('@FiThnitek/FiThnitek/modifierdemande.html.twig' , array('demande'=> $demande,'user'=>$user));
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



            $notification= new Notification();
            $notification
                ->setTitle('Reservation Taxi')
                ->setDescription(' a fait une demande de taxi ')
                ->setRoute('fi_thnitek_affichedemandeuser')
                ->setParameters(array('id'=>$demande->getId()))
                ->setIduser($user)


            ;
            $notification->setIdarticle($demande);
            $notification->setType('Chauffeur');
            $em->persist($notification);

            $em->flush();
            $pusher = $this->get('mrad.pusher.notificaitons');
            $pusher->trigger($notification);




            return $this->redirectToRoute("fi_thnitek_affichereservation") ;

        }







    }
 //////////////////// BACK        /////////////////////////////////////////


    public function affichedemandeBAction(Request $request)

    {
        if($request->isMethod('POST'))
        {  $region=$request->get('region');
            $t='Chauffeur';
            $t2='Client';
            $mod=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t);
            $sup=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t2);
                $em=$this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->regiononly($region);
            $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
                return $this->render('@FiThnitek/FiThnitekBack/afficherdemande.html.twig', array('a' => $em , 'b'=>$emm ,'chauffeur'=>$mod,'client'=>$sup));

        }

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $idu=$user->getId();

        $count= $this->getDoctrine()->getManager()->getRepository(Notification::class)->count($idu);
        $use= $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        //$c =$count[0];
        //var_dump($count);
        //$count='123';
        $t='Chauffeur';
        $t2='Client';

        $mod=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t);
        $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
        $sup=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t2);
        $em = $this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->findAll();
        //$emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
        return $this->render('@FiThnitek/FiThnitekBack/afficherdemande.html.twig', array('a' => $em, 'u'=>$use,'b'=>$emm, 'chauffeur'=>$mod,'client'=>$sup));
    }



    public function ajouterdemandeBAction(Request $request)
    {    $em=$this->getDoctrine()->getManager();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $demande = new DemandeTaxi();
        if ($request->isMethod('POST')) {
            $finduser = $this->getDoctrine()->getRepository(User::class)->find($request->get('idu'));

            $demande->setIduser( $finduser);
            $demande->setLieudarrive($request->get('lieua'));
            $demande->setLieudedepart($request->get('lieud'));
            $demande->setPeriode($request->get('periode'));
            $demande->setEtat(0);
            $demande->setPrix(15);
            $demande->setDateD($request->get('dated'));
            $demande->setRegion($request->get('region'));
            $em->persist($demande);

            $em->flush();
           // return $this->redirectToRoute("fi_thnitek_affichedemandeB") ;
        }
        $t='Chauffeur';
        $t2='Client';

        $mod=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t);
        $mimi= $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
        $sup=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t2);
        $emm = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('@FiThnitek/FiThnitekBack/ajouterdemande.html.twig' , array('demande'=> $demande ,'id'=>$emm ,'b'=>$mimi, 'chauffeur'=>$mod,'client'=>$sup)  );
    }

    public function affichereservationBAction(Request $request)
    {
        if($request->isMethod('POST'))
        {  $id=$request->get('user');

            $em=$this->getDoctrine()->getManager()->getRepository(reservationTaxis::class)->siwar($id);

            $t1='Chauffeur';
            $t2='Client';


            $mod=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t1);
            $sup=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t2);
            $emm= $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
            $use= $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
            return $this->render('@FiThnitek/FiThnitekBack/affichereservation.html.twig',array('a'=>$em,'u'=>$use,'b'=>$emm, 'chauffeur'=>$mod,'client'=>$sup));

        }


        else {$user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id=$user->getId();
            $t1='Chauffeur';
            $t2='Client';


            $em = $this->getDoctrine()->getManager()->getRepository(reservationTaxis::class)->findAll();
            $mod=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t1);
            $sup=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t2);
            $emm= $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
        $use= $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('@FiThnitek/FiThnitekBack/affichereservation.html.twig',array('a'=>$em,'u'=>$use,'b'=>$emm, 'chauffeur'=>$mod,'client'=>$sup));
    }}

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
/////////////////////////////////////////NoTIFICATION                 ////////////////////////


     public function NotificationUserAction()
     {$em = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();

         return $this->render('@FiThnitek/FiThnitek/affichenotif.html.twig', array('a' => $em));


     }

    public function supprimernotifAction($id)
    {$em=$this->getDoctrine()->getRepository(Notification::class)->find($id);
        $demande=$this->getDoctrine()->getManager();
        $demande->remove($em);
        $demande->flush();
        //$emm=$this->getDoctrine()->getRepo
        //sitory(DemandeTaxi::class)->findAll();
        return $this->redirectToRoute("fi_thnitek_affichedemandeB") ;
    }


    public function etat1Action( )
    {
        $t1='Chauffeur';
        $t2='Client';
        $mod=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t1);
        $sup=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t2);
        $em=$this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->etat1();
        $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
        return $this->render('@FiThnitek/FiThnitekBack/afficherdemande.html.twig', array('a' => $em , 'b'=>$emm, 'chauffeur'=>$mod,'client'=>$sup));


    }

    public function etat0Action( )
    {$t1='Chauffeur';
        $t2='Client';
        $mod=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t1);
        $sup=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t2);
        $em=$this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->etat0();
        $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
        return $this->render('@FiThnitek/FiThnitekBack/afficherdemande.html.twig', array('a' => $em , 'b'=>$emm, 'chauffeur'=>$mod,'client'=>$sup));


    }


    public function userAction($id )
    {

        $em=$this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();



        return $this->render('@FiThnitek/FiThnitekBack/afficheruser.html.twig', array('a' => $em , 'b'=>$emm));


    }

    public function demandeAction($id )
    {     $t1='Chauffeur';
        $t2='Client';


        $mod=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t1);
        $sup=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t2);
        //$emm= $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
       // $use= $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();

        $em=$this->getDoctrine()->getManager()->getRepository(DemandeTaxi::class)->find($id);
        $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
        return $this->render('@FiThnitek/FiThnitekBack/afficherdemande1.html.twig', array('a' => $em , 'b'=>$emm, 'chauffeur'=>$mod,'client'=>$sup));


    }
    public function notifchAction()
    {$t='Chauffeur';
    $t2='Client';

        $mod=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t);
        $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
        $sup=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t2);
       // $emm= $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
        $use= $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('@FiThnitek/FiThnitekBack/affichenotifc.html.twig', array( 'b'=>$emm,'u'=>$use,'b'=>$emm, 'chauffeur'=>$mod,'client'=>$sup));


    }
    public function notifclAction()
    {$t='Chauffeur';
        $t2='Client';

        $mod=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t2);
        $emm = $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
        $sup=$this->getDoctrine()->getManager()->getRepository(Notification::class)->trieb($t);
        // $emm= $this->getDoctrine()->getManager()->getRepository(Notification::class)->findAll();
        $use= $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('@FiThnitek/FiThnitekBack/affichenotifc.html.twig', array( 'b'=>$emm,'u'=>$use,'b'=>$emm, 'chauffeur'=>$mod,'client'=>$sup));


    }

/// //////////////////////////////////////////////////////////////////////////////////////////////
    /*public function sendNotificationAction(Request $request)
    {
        $manager = $this->get('mgilet.notification');
        $notif = $manager->createNotification('Hello world!');
        $notif->setMessage('This a notification.');
        $notif->setLink('http://localhost/FiThnitek-master/web/app_dev.php/FiThnitek/Taxi/affichedemande');
        // or the one-line method :
        // $manager->createNotification('Notification subject', 'Some random text', 'https://google.fr/');

        // you can add a notification to a list of entities
        // the third parameter `$flush` allows you to directly flush the entities
        $manager->addNotification(array($this->getUser()), $notif, true);
    }*/
    }