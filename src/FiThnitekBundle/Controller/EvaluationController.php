<?php


namespace FiThnitekBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FiThnitekBundle\Entity\Evaluation;


class EvaluationController extends Controller
{
function addRatingAction(Request $request, $id)
{
    $rating = new Evaluation();
    $upd=$this->getDoctrine()->getManager();

    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    if($request->isMethod('POST'))
    {
        $rating->setNote($request->get('rating'));
        $rating->setCommentaire($request->get('comment'));
        $rating->setIdClient($user);
        $u=$upd->getRepository('AppBundle:User')->find($id);
        $rating->setUtilisateur($u);
        $e=$upd->getRepository('FiThnitekBundle:Evaluation')->verifier($user,$id);
        $o=0;
        $ca =new Evaluation();
        $c=$request->get('comment');
        $r=$request->get('rating');
        foreach ($ca as $e)
        {if ($ca!=null)
        {
            $o+=1;
        }}
        if ($o==0){$upd->persist($rating);}
        else {$rating = $upd->getRepository('FiThnitekBundle:Evaluation')->updatecomment($id, $c,$r);}

        $upd->flush();
        return $this->redirectToRoute('fi_thnitek_showrating');
    }
    return $this->render('@FiThnitek/FiThnitek/profile.html.twig');
}

function showRatingAction()
{
$user= $this->container->get('security.token_storage')->getToken()->getUser();
$id=$user->getId();
$em=$this->getDoctrine()->getManager();
$rating=$em->getRepository('FiThnitekBundle:Evaluation')->afficherrating($id);
return $this->render('@FiThnitek/FiThnitek/mesrating.html.twig',array('Rating'=>$rating));
}
function deleteRatingAction($id)
{
    $em=$this->getDoctrine()->getManager();
    $rating=$em->getRepository('FiThnitekBundle:Evaluation')->find($id);

    $em->remove($rating);
    $em->flush();
    return $this->redirectToRoute('fi_thnitek_showrating');
}
function editratingAction(Request $request,$id)
{
    $em=$this->getDoctrine()->getManager();
    if($request->isMethod('post')) {
       $c=$request->get('comment');
       $r=$request->get('rating');
       $rating = $em->getRepository('FiThnitekBundle:Evaluation')->updatecomment($id, $c,$r);
        $em->flush();
        return $this->redirectToRoute('fi_thnitek_showrating');
    }
    return $this->render('@FiThnitek/FiThnitek/profile.html.twig');
}
function afficherstatAction()
{
    $count=0;
    $five=0;
    $four=0;
    $three=0;
    $two=0;
    $one=0;
    $total=0;

    $em=$this->getDoctrine()->getManager();
    $rating=$em->getRepository('FiThnitekBundle:Evaluation')->findAll();
    //$ratingtab = (array) json_decode(json_encode($rating));

    foreach ($rating as $stat)
    {
        $count+=1;
        if($stat->getNote()==1){$one+=1;
        $total+=1;}
        elseif ($stat->getNote()==2)
        {$two+=1;
        $total+=2;}
        elseif ($stat->getNote()==3){$three+=1;
        $total+=3;}
        elseif ($stat->getNote()==4){$four+=1;
        $total+=4;}
        elseif ($stat->getNote()==5){$five+=1;
        $total+=5;}

    }
$fiveStarRatingPercent = round(($five/5)*100);
$fiveStarRatingPercent = !empty($fiveStarRatingPercent)?$fiveStarRatingPercent.'%':'0%';

$fourStarRatingPercent = round(($four/5)*100);
$fourStarRatingPercent = !empty($fourStarRatingPercent)?$fourStarRatingPercent.'%':'0%';

$threeStarRatingPercent = round(($three/5)*100);
$threeStarRatingPercent = !empty($threeStarRatingPercent)?$threeStarRatingPercent.'%':'0%';

$twoStarRatingPercent = round(($two/5)*100);
$twoStarRatingPercent = !empty($twoStarRatingPercent)?$twoStarRatingPercent.'%':'0%';

$oneStarRatingPercent = round(($one/5)*100);
$oneStarRatingPercent = !empty($oneStarRatingPercent)?$oneStarRatingPercent.'%':'0%';

    $averge=$total/$count;
    $tab= array('un'=>$oneStarRatingPercent ,
        'deux'=>$twoStarRatingPercent ,
        'trois'=>$threeStarRatingPercent ,
        'quatre'=>$fourStarRatingPercent ,
        'cinq'=> $fiveStarRatingPercent ,
        'average' =>$averge,
        'one'=>$one ,
        'two'=>$two ,
        'three'=>$three ,
        'four'=>$four ,
        'five'=> $five ,
    );
    return $this->render('@FiThnitek/FiThnitek/stat.html.twig',array('Stat'=> $tab
    ));

}
function afficherusersAction()
{
    $em=$this->getDoctrine()->getManager();
   $users= $em->getRepository('AppBundle:User')->findAll();
   return $this->render('@FiThnitek/FiThnitek/listeusers.html.twig',array('User'=> $users));
}

}