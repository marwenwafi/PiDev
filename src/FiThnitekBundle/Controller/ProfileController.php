<?php

namespace FiThnitekBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\DBAL\Types\IntegerType;
use FiThnitekBundle\Entity\Convertirpoints;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{
    /************************Convertir mes points***********/


    public function ConverssionAction(Request $request)
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        //$converssion=new Convertirpoints();
        $mn = $this->getDoctrine()->getManager();
        $myUser= $mn->getRepository(User::class)->find($user);


        $pointschoisi=(int)$request->get('Points');

        $cadeaux=null;
        if ($request->isMethod('POST')) {




            if($myUser->getPoints() >= $pointschoisi)
            {
                if($pointschoisi==1000)
                {
                    $cadeaux="carnet de 5 ticket de 1dt";
                }
                elseif($pointschoisi==5000)
                {
                    $cadeaux="carnet de 28 ticket de 1dt";
                }
                elseif($pointschoisi==10000)
                {
                    $cadeaux="carnet de 60 ticket de 1dt";
                }
                $myUser->setPoints($myUser->getPoints() - $pointschoisi);
                dump($cadeaux);
                $converssion=new Convertirpoints($myUser,$cadeaux);
                $mn->persist($converssion);
                $mn->persist($myUser);
                $mn->flush();




                new \Symfony\Component\HttpFoundation\Response("ok");
            }

        }

        return $this->render('@FiThnitek/Event/Converssion2.html.twig',array('user'=>$myUser));

    }


}
