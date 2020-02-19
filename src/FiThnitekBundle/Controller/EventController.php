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
            $request->query->getInt('limit', 2) /*limit per page*/

        );

        return $this->render('@FiThnitek/Event/read.html.twig',array('event'=>$event));
    }

    /***************Users*******************/

    public function readAllUsersAction()
    {
        $em= $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();
        return $users;
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
        $form= $this->createForm(Event2Type::class, $event);
        dump($request);
        $form= $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){



            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute("fi_thnitek_readEvent");

        }
        return $this->render('@FiThnitek/Event/modEventT.html.twig', array('f'=>$form->createView()));


    }
    /*******************Other *****************/

    public function participerAction($id)
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser();//->getId();
        //dump($user);
       // $idu=$user->getId();


        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->find($id);
        //$user= $mn->getRepository(User::class)->find(1);

        $url=$event->getUrl();
        if($event->getOperation()=='Questionnaire')
        {
            return $this->redirectToRoute("fi_thnitek_readonequest", array(
                'id' => $id));
        }
        elseif ($event->getOperation()=='Publicité'){

            return $this->redirect($url);
      //
            //$promo=$user->getPromotion();
            //$user->setPoints($user->getPoints()+$promo);

        }




    }
    public function repondreAction($id)
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser();//->getId();
        //dump($user);


        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->find($id);



            //
            //$promo=$user->getPromotion();
            //$user->setPoints($user->getPoints()+$promo);
        return $this->redirectToRoute('fi_thnitek_homepage');





    }







}
