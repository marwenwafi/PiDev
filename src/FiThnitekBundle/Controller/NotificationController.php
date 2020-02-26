<?php

namespace FiThnitekBundle\Controller;

use AppBundle\Entity\User;
use FiThnitekBundle\Entity\Notification;
use FiThnitekBundle\Entity\ParticipeEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NotificationController extends Controller
{
    public function readNoPartAction(Request $request)
    {
        $mn = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $myUser= $mn->getRepository(User::class)->find($user);
        $participi=$mn->getRepository(ParticipeEvent::class)->findBy(array('userid'=>$myUser));
        $notifications = $mn->getRepository('FiThnitekBundle:Notification')->findAll();
       // dump($participi);
       // $notif=array();
        $idevent=array();
        $mynotif=array();

        if($participi == null){
            $query=$notifications;

        }

        else{
            foreach ($participi as $p)
            {
                $idevent[]=$p->getEventid()->getId();
            }
            foreach ($notifications as $n)
            {
                $ideventnotif[]=$n->getIdEvent();
            }

            $x= array_diff($ideventnotif,$idevent);

                $mesnot=$mn->getRepository(Notification::class)->findBy(array('idevent'=>$x));

            dump($mesnot);
            dump($notifications);
            dump($idevent);
            dump($ideventnotif);
           // dump($mynotif);
            dump($x);



            $query=$mesnot;

        }



        return $this->render('@FiThnitek/Event/Notification.html.twig',array('event'=>$query));
    }


}
