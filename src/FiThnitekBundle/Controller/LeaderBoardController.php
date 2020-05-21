<?php

namespace FiThnitekBundle\Controller;

use AppBundle\Entity\User;
use FiThnitekBundle\Entity\LeaderBoard;
use FiThnitekBundle\Entity\offreCovoiturage;
use FiThnitekBundle\Entity\ReservationCovoiturage;
use FiThnitekBundle\Form\LeaderBoardType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class LeaderBoardController extends Controller
{
    public function addLeaderBoardAction(Request $request)
    {
        $leaderb = new LeaderBoard();
        $form = $this->createForm(LeaderBoardType::class, $leaderb, array("label"=>"Ajouter"));
        $form = $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($leaderb);
            $em->flush();
            return $this->redirectToRoute("fi_thnitek_listLeaderBoard");
        }
        return $this->render('@FiThnitek/LeaderBoard/AddLeaderBoard.html.twig', array ("f"=>$form->createView()));
    }

    public function modifyLeaderBoardAction(Request $request, $id)
    {
        $leaderb = $this->getDoctrine()->getRepository(LeaderBoard:: class)->find($id);
        $form = $this->createForm(LeaderBoardType::class, $leaderb, array("label"=>"Modifier"));
        $form = $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($leaderb);
            $em->flush();
            return $this->redirectToRoute("fi_thnitek_listLeaderBoard");
        }
        return $this->render('@FiThnitek/LeaderBoard/ModifyLeaderBoard.html.twig', array ("f"=>$form->createView()));
    }

    public function deleteLeaderBoardAction($id)
    {
        $cat = $this->getDoctrine()->getRepository(LeaderBoard:: class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($cat);
        $em->flush();
        return $this->redirectToRoute("fi_thnitek_listLeaderBoard");
    }

    public function ListLeaderBoardAction()
    {
        $mod = $this->getDoctrine()->getRepository(LeaderBoard:: class)->findAll();
        return $this->render('@FiThnitek/LeaderBoard/ListLeaderBoard.html.twig', array('table'=>$mod));
    }

    public function showLeaderBoardAction()
    {

        $leaderBoardS = $this->getDoctrine()->getRepository(LeaderBoard::class)->findAll();
        $repo = $this->getDoctrine()->getManager()->getRepository(LeaderBoard:: class);
        $size = sizeof($leaderBoardS);
        $results = [];
        for ($i=0;$i<$size;$i++)
        {
            $l = $this->getDoctrine()->getRepository(LeaderBoard:: class)->find($leaderBoardS[$i]->getIdleaderboard());
            $results[] = $repo->customQuery($l->getCategory(),$l->getSize(),$l->getStartDate()->format('Y-m-d'),$l->getEndDate()->format('Y-m-d'));
        }

        return $this->render('@FiThnitek/LeaderBoard/ShowLeaderBoard.html.twig', array('results'=>$results,'boards'=>$leaderBoardS));
    }

    public function allLBListAction()
    {
        $leaderBoardS = $this->getDoctrine()->getRepository(LeaderBoard::class)->findAll();
        $lb = [];
        for ($i=0;$i<sizeof($leaderBoardS);$i++)
        {
            $l = $this->getDoctrine()->getRepository(LeaderBoard:: class)->find($leaderBoardS[$i]->getIdleaderboard());
            $l->setStartDate($l->getStartDate()->format('Y-m-d'));
            $l->setEndDate($l->getEndDate()->format('Y-m-d'));
            $l->setCategory(null);
            $lb[] = $l;
        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($lb);
        return new JsonResponse($formatted);
    }

    public function lbDetailsAction($idl)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(LeaderBoard:: class);
        $l = $this->getDoctrine()->getRepository(LeaderBoard:: class)->find($idl);
        $results = $repo->customQuery($l->getCategory(),$l->getSize(),$l->getStartDate()->format('Y-m-d'),$l->getEndDate()->format('Y-m-d'));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($results);
        return new JsonResponse($formatted);
    }
}