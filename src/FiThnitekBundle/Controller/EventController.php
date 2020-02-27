<?php

namespace FiThnitekBundle\Controller;


use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use FiThnitekBundle\Entity\Convertirpoints;
use FiThnitekBundle\Entity\Event;
use FiThnitekBundle\Entity\Notification;
use FiThnitekBundle\Entity\NotificationEvent;
use FiThnitekBundle\Entity\ParticipeEvent;
use FiThnitekBundle\Entity\Questionnaire;
use FiThnitekBundle\Form\Event2Type;
use FiThnitekBundle\Form\EventType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EventController extends Controller
{

    /****************LIRE ********************/

    public function readAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $query= $em->getRepository('FiThnitekBundle:Event')->findAll();


        /**
         *@ var $paginator \Knp\Component\Pager\Paginator
         */


        $paginator=$this->get("knp_paginator");
       /* $dql   = "SELECT a FROM FiThnitekBundle:Event a";
        $query = $em->createQuery($dql);*/
        $event=$paginator->paginate(
          $query,
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit', 4) /*limit per page*/

        );

        return $this->render('@FiThnitek/Event/read.html.twig',array('event'=>$event));
    }





    /**********************READ ONE*****************************/
    public function readOneAction($id)
    {

        $em= $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->find($id);
        //return $this->render('@FiThnitek/Event/affichageDetails.html.twig',array('me'=>$event));

            return $this->render('@FiThnitek/Event/affichageDetails.html.twig',array('me'=>$event));



    }


    /*******************Delete *****************/

    public function deleteAction($id)
    {
        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->find($id);
        $mn->remove($event);
        $mn->flush();
        return $this->redirectToRoute("fi_thnitek_readEvent");

    }

    /*******************Ajout *****************/


    public function ajouterEventAction(Request $request) {

        $event = new Event();
        $em=$this->getDoctrine()->getManager();
      //  $eventy= $em->getRepository(User::class)->findAll();


        $form= $this->createForm(EventType::class, $event);
        //dump($request);
        $form= $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('events_directory'), $fileName);
            $event->setImage($fileName);
            $event->setEtat("En attente");

            $em->persist($event);
            $em->flush();



            if($event->getOperation()=='Questionnaire')
            {
                return $this->redirectToRoute("fi_thnitek_ajouterques2", array(
                    'id' => $event->getId()));
            }
            return $this->redirectToRoute("fi_thnitek_readEvent");

        }
        return $this->render('@FiThnitek/Event/ajouterEventT.html.twig', array('f'=>$form->createView()));


    }

    /*******************Update *****************/

    public function updateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $event= $em->getRepository(Event::class)->find($id);
        $image=$event->getImage();
       // $event->setImage("sourour.png");
        //$x=$request->files->get('fiThnitekbundle_event')['image'];
        //dump($x);

        dump($request);
        $form= $this->createForm(Event2Type::class, $event);
        $form= $form->handleRequest($request);

        if($form->isSubmitted() ){

            /****************************
            if ($event->getImage()=="sourour" && $request->files->get('fiThnitekbundle_event')['image']==null  ) {

                $event->setImage($image);
                $em->persist($event);
                $em->flush();


            }



            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('events_directory'), $fileName);
            $event->setImage($fileName);
            $event->setEtat("En attente");

            $em->persist($event);
            $em->flush();






            /***********************/




            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute("fi_thnitek_readEvent");

        }
       // return $this->render('@FiThnitek/Event/ajouterEventT.html.twig', array('f'=>$form->createView()));
      return $this->render('@FiThnitek/Event/modEventT.html.twig', array('f'=>$form->createView()));


    }
    /******************* PARTICIPER *****************/

    public function participerAction($id)
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->find($id);
        $myUser= $mn->getRepository(User::class)->find($user);
        $url=$event->getUrl();
        $participi=$mn->getRepository(ParticipeEvent::class)->myfindby($myUser,$event);

        if( $event->getEtat()=="Visible" && $participi == null) {

            if ($event->getOperation() == 'Questionnaire') {
                return $this->redirectToRoute("fi_thnitek_repondre", array(
                    'id' => $id));
            } elseif ($event->getOperation() == 'Publicité') {

                $myUser->setPoints($myUser->getPoints() + $event->getPromotion());
                $participation=new ParticipeEvent($myUser,$event);
                $mn->persist($participation);

                $mn->persist($event);
                $mn->flush();

                return $this->redirect($url);



            }

            return $this->render('@FiThnitek/Event/affichageDetails.html.twig', array('me' => $event));
        }
        else {
            return new Response("vous avez déja participé à cette évenement");
        }

    }

    /************************* REPONDRE **************************/

    public function repondreAction(Request $request, $id)
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->find($id);
        $myUser= $mn->getRepository(User::class)->find($user);
        $events2 = $mn->getRepository(Questionnaire::class)->findBy(array('idevent'=>$id));
        $participi=$mn->getRepository(ParticipeEvent::class)->myfindby($myUser,$event);
        if( $event->getEtat()=="Visible" && $participi == null) {

        if ($request->isMethod('POST') ) {


                $myUser->setPoints($myUser->getPoints() + $event->getPromotion());
                $participation=new ParticipeEvent($myUser,$event);
                $mn->persist($participation);
                $mn->persist($event);
                $mn->flush();
                return $this->redirectToRoute('fi_thnitek_homepage');

           }

       return $this->render('@FiThnitek/Event/affichageDetailsQ.html.twig',array('quest'=>$event,'events2'=>$events2));
        }
        else{
            return new Response("vous avez déja participé à cette évenement");
        }
    }

    /**************** ACTIVER ******************/

    public function ActiverAction($id)
    {
        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->find($id);
        $notif=$mn->getRepository(NotificationEvent::class)->findOneBy(array('idevent'=>$id));

        $event->setEtat("Visible");
        $mn->persist($event);
        $mn->flush();
        if($notif == null){


        //////  DEBUT NOTIFICATION //////

        $notification= new NotificationEvent();
        $notification
            ->setTitle($event->getTitre())
            ->setDescription($event->getPromotion())
            ->setRoute('fi_thnitek_readoneevent')
            ->setParameters(array('id'=>$event->getId()
            ))
            ->setIdEvent($id)




        ;

        $mn->persist($notification);

        $mn->flush();
        $pusher = $this->get('mrad.pusher.notificaitons');
        $pusher->trigger($notification);
        //dump($pusher);
        ///// FIN NOTIFICATION //////
        return $this->redirectToRoute("fi_thnitek_readEvent");
        }
        return new Response("l'évenement est déja activé");

    }
/******************Afficher les evenements non repondus ********************/
    public function AfficherNonReponduAction($id)
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->find($id);
        $myUser= $mn->getRepository(User::class)->find($user);
        $participi=$mn->getRepository(ParticipeEvent::class)->myfindby($myUser,$event);


        if( $event->getEtat()=="Visible" && $participi!= null )
        {
            return $this->render('@FiThnitek/Event/affichageDetails.html.twig',array('me'=>$event));
        }
        return $this->redirectToRoute("fi_thnitek_homepage");


    }
    /********************** DESACTIVER ************************/
    public function desactiverAction($id)
    {
        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->find($id);
        $notif= $mn->getRepository(NotificationEvent::class)->findOneBy(array('idevent'=>$id));
        $notif=$mn->getRepository(NotificationEvent::class)->findOneBy(array('idevent'=>$id));
        if($notif != null){

        $event->setEtat("Invisible");
        $mn->persist($event);
        $mn->flush();
        //////  DEBUT NOTIFICATION //////


        $mn->remove($notif);

        $mn->flush();

        ///// FIN NOTIFICATION //////
        return $this->redirectToRoute("fi_thnitek_readEvent");

    }
        return new Response("l'évenement est déja désactivé");
    }












}
