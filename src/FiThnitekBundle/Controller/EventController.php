<?php

namespace FiThnitekBundle\Controller;


use FiThnitekBundle\Entity\Event;
use FiThnitekBundle\Entity\Questionnaire;
use FiThnitekBundle\Form\EventType;
use FiThnitekBundle\Form\EventType1;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class EventController extends Controller
{
    public function mmAction()
    {
        return $this->render('@FiThnitek/Event/index.html.twig');
    }
    public function readAction()
    {
        $em= $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->findAll();
        return $this->render('@FiThnitek/Event/read.html.twig',array('event'=>$event));
    }
    /**********************READ ONE*****************************/
    public function readOneAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->find($id);
        return $this->render('@FiThnitek/Event/affichageDetails.html.twig',array('me'=>$event));

        return $this->render('@FiThnitek/Event/affichageDetails.html.twig',array('me'=>$event));
    }

    public function readOne2Action(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $event= $em->getRepository(Event::class)->find($id);
        $dated= new \DateTime($request-> getFormat('datedebut'));
        $datef= new \DateTime($request-> getFormat('datefin'));

        if($request -> isMethod('POST')){
            $event-> setTitre($request-> get('titre'));
            $event-> setDateDebut($dated);
            $event-> setDateFin($datef);
            $event-> setPromotion($request-> get('promo'));
            $event-> setDescription($request-> get('description'));
            $event-> setEtat($request-> get('etat'));
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('fi_thnitek_readEvent') ;
        }

        return $this->render('@FiThnitek/Event/readOne2.html.twig', array('event'=>$event));

    }

    /************************************/

    public function deleteAction($id)
    {
        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->find($id);
        $mn->remove($event);
        $mn->flush();
        return $this->redirectToRoute("fi_thnitek_readEvent");

    }




    public function ajouterEventAction(Request $request) {

        $event = new Event();
        $form= $this->createForm(EventType::class, $event);
        $form= $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('events_directory'), $fileName);
            $event->setImage($fileName);


            $em=$this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute("fi_thnitek_readEvent");

        }
        return $this->render('@FiThnitek/Event/ajouterEvent0.html.twig', array('f'=>$form->createView()));


    }

    public function updateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $event= $em->getRepository(Event::class)->find($id);
        $dated= new \DateTime($request-> getFormat('datedebut'));
        $datef= new \DateTime($request-> getFormat('datefin'));

        if($request -> isMethod('POST')){
            $event-> setTitre($request-> get('titre'));
            $event-> setDateDebut($dated);
            $event-> setDateFin($datef);
            $event-> setPromotion($request-> get('promo'));
            $event-> setDescription($request-> get('description'));
            $event-> setEtat($request-> get('etat'));
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('fi_thnitek_readEvent') ;
        }

        return $this->render('@FiThnitek/Event/modifierEvent.html.twig', array('event'=>$event));

    }






}
