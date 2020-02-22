<?php

namespace FiThnitekBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\PieChart\PieChartOptions;
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

    public function listObjectifAction()
    {
        $mod = $this->getDoctrine()->getRepository(Objectif:: class)->findAll();
        $repo = $this->getDoctrine()->getManager()->getRepository(Objectif:: class);
        $rescov = $repo->customQuery("Revenues Covoiturage",date("yy-m-d", mktime(0,0,0,2,1,2020)),date("yy-m-d", mktime(0,0,0,2,28,2020)));
        $rescol = $repo->customQuery("Revenues Colis",date("yy-m-d", mktime(0,0,0,2,1,2020)),date("yy-m-d", mktime(0,0,0,2,28,2020)));
        $pieChart = new PieChart();
        var_dump($rescov[0][1]);
        $pieChart->getData()->setArrayToDataTable(
            [['Source', 'Revenues'],
                ['Covoiturage',  (int)$rescov[0][1]],
                ['Colis',   (int) $rescol[0][1]],
            ]
        );
        $pieChart->getOptions()->setTitle('Distribution Revenues');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('@FiThnitek/Objectif/ListObjectif.html.twig', array('table'=>$mod,'piechart'=>$pieChart));
    }

    public function detailsObjectifAction(Request $request, $id)
    {
        $objectif = $this->getDoctrine()->getRepository(Objectif:: class)->find($id);
        if ($request->isMethod('POST'))
        {
            if ($request->get('_submit')) {
                $objectif = $this->getDoctrine()->getRepository(Objectif:: class)->find($id);
                $te = $request->get('_submit');
                if ($te == "true")
                    $objectif->setEtat(false);
                else if ($te == "false")
                    $objectif->setEtat(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($objectif);
                $em->flush();
            }
        }
        if ($objectif->getEtat())
        {
            $repo = $this->getDoctrine()->getManager()->getRepository(Objectif:: class);
            $res = $repo->customQuery($objectif->getType(),$objectif->getStartDate()->format('Y-m-d'),$objectif->getEndDate()->format('Y-m-d'));
            var_dump($res);
            $total = 0;
            for($i=0;$i<sizeof($res);$i++)
                $total += $res[$i][1];
            $percent = ($total / $objectif->getBut())*100;
            return $this->render('@FiThnitek/Objectif/DetailsObjectif.html.twig', array('table'=>$objectif, 'percent'=>$percent,'total'=>$total));
        }
        return $this->render('@FiThnitek/Objectif/DetailsObjectif.html.twig', array('table'=>$objectif));
    }

}
