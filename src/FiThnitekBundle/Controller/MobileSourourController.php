<?php

namespace FiThnitekBundle\Controller;


use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use FiThnitekBundle\Entity\Convertirpoints;
use FiThnitekBundle\Entity\Event;
use FiThnitekBundle\Entity\Notification;
use FiThnitekBundle\Entity\NotificationEvent;
use FiThnitekBundle\Entity\ParticipeEvent;
use FiThnitekBundle\Entity\Questionnaire;
use FiThnitekBundle\Form\Event2Type;
use FiThnitekBundle\Form\EventType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MobileSourourController extends Controller
{

    /****************LIRE Events ********************/

    public function readAction(Request $request)
{
    $em= $this->getDoctrine()->getManager();
    $query= $em->getRepository('FiThnitekBundle:Event')->findAll();

    $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
    $serializer = new Serializer($normalizer);
   $formatted = $serializer -> normalize($query,[DateTimeNormalizer:: FORMAT_KEY => 'Y-m-d' ]);
   return new JsonResponse($formatted);
}

    /****************LIRE Notifications ********************/


    public function readNoPartAction(Request $request)
    {


        $mn = $this->getDoctrine()->getManager();
        
        // $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        /**** TOOOOOOOOOOOOOOOOOOOOOO MODIFY BY $user*********************************
          */

        $myUser= $this->get('security.token_storage')->getToken()->getUser()->getId();
        
        $participi=$mn->getRepository(ParticipeEvent::class)->findBy(array('userid'=>$myUser));
        $notifications = $mn->getRepository(NotificationEvent::class)->findAll();
        $ideventnotif=array();
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

            $mesnot=$mn->getRepository(NotificationEvent::class)->findBy(array('idevent'=>$x));
             $query=$mesnot;

        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer -> normalize($query);
        return new JsonResponse($formatted);

    }


    /*********************************************************/

    /***************************** AJOUT *****************************************/

    public function newEventAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $event = new Event();
            $event->setTitre($request->get('titre'));
            $event->setEtat($request->get('etat'));
            $event->setImage($request->get('image'));
            $event->setPromotion($request->get('promotion'));
            $event->setDescription($request->get('description'));
            $event->setUrl($request->get('url'));
            $event->setOperation($request->get('operation'));
            $datef = new \DateTime($request->get('dateFin'));
			$dated = new \DateTime($request->get('dateDebut'));
            $event->setDateDebut($dated);
            $event->setDateFin($datef);


        $em->persist($event);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($event);
        return  new JsonResponse($formatted);
    }
    /************************Convertir mes points***********/


    public function ConverssionJsonAction(Request $request)
    {

        //$user = $this->container->get('security.token_storage')->getToken()->getUser();

        $mn = $this->getDoctrine()->getManager();
        /******************** POUR TEST KAHAW *********************/
        $user= $this->get('security.token_storage')->getToken()->getUser()->getId();
           /*****************à supprimer **********************/

        $pointschoisi=(int)$request->get('Points');
        $cadeaux=null;

            if($user->getPoints() >= $pointschoisi)
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
                $user->setPoints($user->getPoints() - $pointschoisi);
                dump($cadeaux);
                $converssion=new Convertirpoints($user,$cadeaux);
                $mn->persist($converssion);
                $mn->persist($user);
                $mn->flush();

            }
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($converssion);
            return new JsonResponse($formatted);





    }
    /*********************** THIS USER ******************************/
    public function thisUserJsonAction(Request $request)
    {
        //$user = $this->container->get('security.token_storage')->getToken()->getUser();

        /******************** POUR TEST KAHAW *********************/
        $mn = $this->getDoctrine()->getManager();
        $user= $this->get('security.token_storage')->getToken()->getUser()->getId();
        /*****************à supprimer **********************/
        $pionts=$user->getPoints();
        return new Response($pionts);

    }
    /*********************************** REMOVE Event ************************************/
    public function deleteJsonAction($id)
    {
        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->find($id);
        $mn->remove($event);
        $mn->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);

    }
    /***********************************  EDIT EVENT ***************************************/
    public function updateJsonAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $event= $em->getRepository(Event::class)->find($id);


        $event->setTitre($request->get('titre'));
        $event->setEtat($request->get('etat'));
       $event->setImage($request->get('image'));
        $event->setPromotion($request->get('promotion'));
        $event->setDescription($request->get('description'));
        $event->setUrl($request->get('url'));
        $event->setOperation($request->get('operation'));
		$datef = new \DateTime($request->get('dateFin'));
		$dated = new \DateTime($request->get('dateDebut'));
        $event->setDateDebut($dated);
        $event->setDateFin($datef);


        $em->persist($event);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($event);
        return  new JsonResponse($formatted);




    }
    /********************* ACTIVATE **********************************/
    public function activerJsonAction($id)
    {
        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->find($id);

        $event->setEtat("Visible");
        $mn->persist($event);
        $mn->flush();


        $notification= new NotificationEvent();
        $notification
            ->setTitle($event->getTitre())
            ->setDescription($event->getPromotion())
            ->setRoute('fi_thnitek_readoneevent')
            ->setParameters(array('id'=>$event->getId()
            ))
            ->setIdEvent($id)
        ;

        $mn->persist($notification);
        $mn->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($event);
        return  new JsonResponse($formatted);
    }

    /***************************  Desactiver  *********************/

    public function desactiverJsonAction($id)
    {
        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->find($id);
        $notif= $mn->getRepository(NotificationEvent::class)->findOneBy(array('idevent'=>$id));

        $event->setEtat("Invisible");
        $mn->persist($event);
        $mn->flush();

        $mn->remove($notif);

        $mn->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($event);
        return  new JsonResponse($formatted);

    }
    /*********************** THIS USER ******************************/
    public function thisEventJsonAction($id)
    {
        $mn = $this->getDoctrine()->getManager();
        $event= $mn->getRepository(Event::class)->findBy(array('id'=>$id));
        $normalizer = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizer);
        $formatted = $serializer -> normalize($event,[DateTimeNormalizer:: FORMAT_KEY => 'Y-m-d' ]);
        return new JsonResponse($formatted);

    }
    /****************************** PARTICIPER  *************************************/
    public function participerJsonAction($id)
    {

       // $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();

        $mn = $this->getDoctrine()->getManager();
        /******************** POUR TEST KAHAW *********************/

        $user= $this->get('security.token_storage')->getToken()->getUser()->getId();
        /*****************à supprimer **********************/
        $event= $mn->getRepository(Event::class)->find($id);
        $myUser= $mn->getRepository(User::class)->find($user);
        $url=$event->getUrl();
        $participi=$mn->getRepository(ParticipeEvent::class)->myfindby($myUser,$event);
        $op="";

        if( $event->getEtat()=="Visible" && $participi == null) {


                $myUser->setPoints($myUser->getPoints() + $event->getPromotion());
                $participation=new ParticipeEvent($myUser,$event);
                $mn->persist($participation);

                $mn->persist($event);
                $mn->flush();
                $op="OK";


        }
        else {
            $op="NOT OK";
        }
        return new Response($op);
    }

    /************************* REPONDRE **************************/

    public function repondreJsonAction(Request $request, $id)
    {

    }
    /*********************************Questionnaire List ***************************************/
    public function quetionnaireListAction(Request $request,$id)
    {
        $em= $this->getDoctrine()->getManager();
        $query=$em->getRepository(Questionnaire::class)->findBy(array('idevent'=>$id));;


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer -> normalize($query);
        return new JsonResponse($formatted);
    }


}







