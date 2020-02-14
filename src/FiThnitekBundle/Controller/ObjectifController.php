<?php

namespace FiThnitekBundle\Controller;

use FiThnitekBundle\Entity\Objectif;
use FiThnitekBundle\Form\ObjectifType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ObjectifController extends Controller
{
    public function addObjectifAction(Request $request)
    {
        $objectif = new Objectif();
        $form = $this->createForm(ObjectifType::class, $objectif, array("label"=>"Ajouter"));
        $form = $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($objectif);
            $em->flush();
            return $this->redirectToRoute("fi_thnitek_listObjectif");
        }
        return $this->render('@FiThnitek/Objectif/AddObjectif.html.twig', array ("f"=>$form->createView()));
    }

    public function modifyObjectifAction(Request $request, $id)
    {
        $objectif = $this->getDoctrine()->getRepository(Objectif:: class)->find($id);
        $form = $this->createForm(ObjectifType::class, $objectif, array("label"=>"Modifier"));
        $form = $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($objectif);
            $em->flush();
            return $this->redirectToRoute("fi_thnitek_listObjectif");
        }
        return $this->render('@FiThnitek/Objectif/ModifyObjectif.html.twig', array ("f"=>$form->createView()));
    }

    public function deleteObjectifAction($id)
    {
        $obj = $this->getDoctrine()->getRepository(Objectif:: class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($obj);
        $em->flush();
        return $this->redirectToRoute("fi_thnitek_listObjectif");
    }

    public function ListObjectifAction()
    {
        $mod = $this->getDoctrine()->getRepository(Objectif:: class)->findAll();
        return $this->render('@FiThnitek/Objectif/ListObjectif.html.twig', array('table'=>$mod));
    }

}
