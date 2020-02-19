<?php

namespace FiThnitekBundle\Controller;




use Doctrine\Common\Collections\ArrayCollection;
use FiThnitekBundle\Entity\Event;
use FiThnitekBundle\Entity\Questionnaire;
use FiThnitekBundle\Form\Questionnaire2Type;
use FiThnitekBundle\Form\QuestionnaireType;
use mysql_xdevapi\CollectionAdd;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class QuestionnaireController extends Controller
{

   /************** LIRE ****************/
    public function readAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();

       // $questionnaire = $em->getRepository(Questionnaire::class)->findAll();
        /**
         *@ var $paginator \Knp\Component\Pager\Paginator
         */

        $paginator=$this->get("knp_paginator");
        //dump(get_class($paginator));
        $dql   = "SELECT a FROM FiThnitekBundle:Questionnaire a";
        $query = $em->createQuery($dql);
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit', 8) /*limit per page*/
        );


        return $this->render('@FiThnitek/Event/readQuestionnaire.html.twig',array('questionnaire'=>$pagination));
    }





    /************** SUPPRIMER ****************/
    public function deleteAction($id)
    {
        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Questionnaire::class)->find($id);
        $mn->remove($event);
        $mn->flush();
        return $this->redirectToRoute("fi_thnitek_readques");

    }


        /************** UPDATE *****************/


    public function updateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $forma= $em->getRepository(Questionnaire::class)->find($id);
        $form= $this->createForm(Questionnaire2Type::class, $forma);
        $em=$this->getDoctrine()->getManager();
        $events=$em->getRepository(Event::class)->findAll();
        $form= $form->handleRequest($request);
        if($form->isValid()){



            $em->persist($forma);
            $em->flush();
            return $this->redirectToRoute("fi_thnitek_readques");




        }
        return $this->render('@FiThnitek/Event/modQuestionnaire33.html.twig', array('f'=>$form->createView(),'ev'=>$events,'e'=>$id));

    }




    /***************** Create ********************/
    public function createAction(Request $request,$id){

        $forma = new Questionnaire();
        $form= $this->createForm(QuestionnaireType::class, $forma);
        $em=$this->getDoctrine()->getManager();
        $events=$em->getRepository(Event::class)->findAll();
        $form= $form->handleRequest($request);
        if($form->isValid()){



            $em->persist($forma);
            $em->flush();
            $myevent=$forma->getIdevent();

            if ($form->getClickedButton() === $form->get('Ajouter')) {
                return $this->redirectToRoute("fi_thnitek_readques");
            }
            if ($form->getClickedButton() === $form->get('Plus')) {
                //$this->createAction(new Request(),$id);
                //$this->$form->setIdevent($myevent);

                $forma = new Questionnaire();
                $form= $this->createForm(QuestionnaireType::class, $forma);
                $em=$this->getDoctrine()->getManager();
                $events=$em->getRepository(Event::class)->findAll();
                $form= $form->handleRequest(new Request());
                if($form->isValid()){

                    $em->persist($forma);
                    $forma->setIdevent($myevent);
                    $em->flush();
                }
            }

        }
        return $this->render('@FiThnitek/Event/ajouterQuestionnaire33.html.twig', array('f'=>$form->createView(),'ev'=>$events,'e'=>$id));

    }


    /**********************READ ONE*****************************/
    public function readOneAction($id)
    {

        $em= $this->getDoctrine()->getManager();

        $ev = $em->getRepository(Event::class)->find($id);

        $events2 = $em->getRepository(Questionnaire::class)->findBy(array('idevent'=>$id));
        dump($events2);

        return $this->render('@FiThnitek/Event/affichageDetailsQ.html.twig',array('quest'=>$ev,'events2'=>$events2));
    }



}
