<?php

namespace FiThnitekBundle\Controller;




use Doctrine\Common\Collections\ArrayCollection;
use FiThnitekBundle\Entity\Questionnaire;
use mysql_xdevapi\CollectionAdd;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class QuestionnaireController extends Controller
{

   /************** LIRE ****************/
    public function readAction()
    {
        $em= $this->getDoctrine()->getManager();
        $questionnaire = $em->getRepository(Questionnaire::class)->findAll();
        return $this->render('@FiThnitek/Event/readQuestionnaire.html.twig',array('questionnaire'=>$questionnaire));
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


    /************** AJOUTER ****************/

    public function ajouterQestionnaireAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $ques = new Questionnaire();
        //$user = $this->container->get('security.token_storage')->getToken()->getUser();
        //dump($user);

        if ($request->isMethod('POST')) {
            //$ques->setIdutilisateur($user);

            $ques->setQuestion($request->get('question'));

            $ques->setReponse1($request->get('reponse1'));
            $ques->setReponse2($request->get('reponse2'));



            $em->persist($ques);
            $em->flush();

            return $this->redirectToRoute("fi_thnitek_readques");
        }
            return $this->render('@FiThnitek/Event/ajouterQuestionnaire.html.twig', array('event' => $ques));


        }

    public function updateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $ques= $em->getRepository(Questionnaire::class)->find($id);


        if ($request->isMethod('POST')) {
            //$ques->setIdutilisateur($user);

            $ques->setQuestion($request->get('question'));

            $ques->setReponse1($request->get('reponse1'));
            $ques->setReponse2($request->get('reponse2'));
            $ques->setEvent($request->get('event'));



            $em->persist($ques);
            $em->flush();

            return $this->redirectToRoute("fi_thnitek_readques");
        }
        return $this->render('@FiThnitek/Event/modifierQuestionnaire.html.twig', array('event' => $ques));


    }






}
