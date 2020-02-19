<?php

namespace FiThnitekBundle\Controller;


use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use FiThnitekBundle\Entity\Event;
use FiThnitekBundle\Entity\Questionnaire;
use FiThnitekBundle\Form\Event2Type;
use FiThnitekBundle\Form\EventType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
            $event->setEtat("visible");



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
       // $image=$event->getImage();
        //$event->setImage("sourour");
        dump($request);
        $form= $this->createForm(Event2Type::class, $event);
        $form= $form->handleRequest($request);

        if($form->isSubmitted() ){




            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute("fi_thnitek_readEvent");

        }
        return $this->render('@FiThnitek/Event/modEventT.html.twig', array('f'=>$form->createView()));


    }
    /*******************Other *****************/

    public function participerAction($id)
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->find($id);
        $myUser= $mn->getRepository(User::class)->find($user);
        //dump($myUser);



        $url=$event->getUrl();
        if($event->getOperation()=='Questionnaire')
        {
            return $this->redirectToRoute("fi_thnitek_repondre", array(
                'id' => $id));
        }
        elseif ($event->getOperation()=='Publicité'){
            $myUser->setPoints($myUser->getPoints() + $event->getPromotion());

            $mn->persist($event);
            $mn->flush();

            return $this->redirect($url);



        }

    }

    public function repondreAction(Request $request, $id)
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->find($id);
        $myUser= $mn->getRepository(User::class)->find($user);
        $events2 = $mn->getRepository(Questionnaire::class)->findBy(array('idevent'=>$id));
        //$reponse=new Response();


        if ($request->isMethod('POST') ) {


                $myUser->setPoints($myUser->getPoints() + $event->getPromotion());

                $mn->persist($event);
                $mn->flush();


            return $this->redirectToRoute('fi_thnitek_homepage');





        }

       // return $this->render('@FiThnitek/Event/affichageDetailsQ.html.twig');
       return $this->render('@FiThnitek/Event/affichageDetailsQ.html.twig',array('quest'=>$event,'events2'=>$events2));





    }







}
