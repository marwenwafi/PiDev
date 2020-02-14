<?php

namespace FiThnitekBundle\Controller;

use FiThnitekBundle\Entity\Reclamation;

use FiThnitekBundle\Entity\Reponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FiThnitekBundle\Repository\ReclamationRepository;

class ReclamationController extends Controller
{
    function ajouterreclamationAction(Request $request)
    {
    $reclamation = new Reclamation();
        //$dateuse =  new \DateTime();
        //$date= $dateuse->format('Y-m-d');

        $upd=$this->getDoctrine()->getManager();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($request->isMethod('POST'))
        {
            $reclamation->setUtilisateur($user);
            $reclamation->setType($request->get('type'));
            $reclamation->setSujet($request->get('sujet'));
            $reclamation->setDescription($request->get('description'));
            $reclamation->setDate("12/03/2020");
            $reclamation->setEtat(false);
            $upd->persist($reclamation);
            $upd->flush();
            return $this->redirectToRoute('fi_thnitek_afficherreclamation');
        }
        return $this->render('@FiThnitek/FiThnitek/contact.html.twig',array('Reclamation'=> $reclamation
        ));
    }
    function afficherreclamationAction()
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository('FiThnitekBundle:Reclamation')->findAll();
        return $this->render('@FiThnitek/FiThnitek/afficher.html.twig',array('Reclamation'=>$reclamation));

    }

    function supprimerreclamationAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository('FiThnitekBundle:Reclamation')->find($id);
        $reponse=$em->getRepository('FiThnitekBundle:Reponse')->removereponse($id);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute('fi_thnitek_afficherreclamation');
    }

    function afficherbackreclamationAction()
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository('FiThnitekBundle:Reclamation')->backreclamation();
        return $this->render('@FiThnitek/FiThnitek/listereclamation.html.twig',array('reclamation'=>$reclamation));

    }
    function repondrereclamationAction(Request $request ,$id)
    {
        $reponse= new Reponse();
        $upd=$this->getDoctrine()->getManager();
        $rec=$upd->getRepository('FiThnitekBundle:Reclamation')->updateetat($id);
        $rec1=$upd->getRepository('FiThnitekBundle:Reclamation')->find($id);

        if ($request->isMethod('POST'))
        {
            $reponse->setReponseRec($request->get('reponse'));

            $reponse->setIdRec($rec1);
            $upd->persist($reponse);
            //$upd->persist($rec);
            //$upd->flush();
            $upd->flush();
            return $this->redirectToRoute('fi_thnitek_afficherbackreclamation');
        }
        return $this->render('@FiThnitek/FiThnitek/repondrereclamation.html.twig');
    }
    function afficherreponseAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reponse=$em->getRepository('FiThnitekBundle:Reponse')->reponseadmin($id);
        return $this->render('@FiThnitek/FiThnitek/reponseadmin.html.twig',array('Reponse'=>$reponse));
    }
}
