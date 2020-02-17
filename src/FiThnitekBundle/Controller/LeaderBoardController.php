<?php

namespace FiThnitekBundle\Controller;

use AppBundle\Entity\User;
use FiThnitekBundle\Entity\LeaderBoard;
use FiThnitekBundle\Entity\offreCovoiturage;
use FiThnitekBundle\Entity\ReservationCovoiturage;
use FiThnitekBundle\Form\LeaderBoardType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        //ALL Ordered By nbr of all offers
        $mod1 = $this->getDoctrine()->getRepository(User:: class)->findBy(array(),array('nbroffre'=>'DESC'));

        //TODO Do this bit in a for loop to get all the leaderBoards configured by the admin
        $leaderBoardS = $this->getDoctrine()->getRepository(LeaderBoard::class)->findAll();
        $repo = $this->getDoctrine()->getManager()->getRepository(LeaderBoard:: class);
        $size = sizeof($leaderBoardS);
        for ($i=0;$i<$size;$i++)
        {
            $l = $this->getDoctrine()->getRepository(LeaderBoard:: class)->find($leaderBoardS[$i]->getIdleaderboard());
            $results[] = $repo->customQuery($l->getCategory(),$l->getSize(),$l->getStartDate()->format('Y-m-d'),$l->getEndDate()->format('Y-m-d'));
        }


        return $this->render('@FiThnitek/LeaderBoard/ShowLeaderBoard.html.twig', array('results'=>$results,'boards'=>$leaderBoardS));
    }

}
