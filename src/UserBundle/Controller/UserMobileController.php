<?php


namespace UserBundle\Controller;


use AppBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserMobileController extends BaseController
{

    public function loginMobileAction(Request $request)
    {
        $factory = $this->get('security.encoder_factory');
        $user_manager = $this->get('fos_user.user_manager');
        $username = $request->get('username');
        $password = $request->get('password');
        $user = $user_manager->findUserByUsername($username);
        $encoder = new BCryptPasswordEncoder(12);
        if ($user == null) {
            return new Response("Incorrect username");
        } elseif (!$encoder->isPasswordValid($user->getPassword(), $password, null)) {
            return new Response("Incorrect password");
        } else {
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
            $user = $this->getDoctrine()->getRepository(User::class)->find($user);
            $normalizer = new ObjectNormalizer ();
            $normalizer->setCircularReferenceHandler(function ($user) {
                return $user->getId();
            });
            $user->setDatedenaissance($user->getDatedenaissance()->format('Y-m-d'));
            $serializer = new Serializer([$normalizer]);
            $formatted = $serializer->normalize($user, null, [ObjectNormalizer::ATTRIBUTES => ['id', 'username', 'email', 'datedenaissance', 'image', 'nbroffre', 'points', 'prenom', 'tel','roles']]);
            return new JsonResponse($formatted);
        }
    }

    public function logoutMobileAction(Request $request)
    {
        return $this->redirectToRoute("fos_user_security_logout");
    }

    /**
     * @Route("/registerMobile", methods={"POST"})
     */
    public function registerMobileAction(Request $request)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $username = $request->get('username');
        $email = urldecode($request->get('email'));
        $user = $user_manager->findUserByUsername($username);
        $user2 = $user_manager->findUserByEmail($email);
        if ($user != null)
            return new Response("Username taken");
        elseif ($user2 != null)
            return new Response("Email already used");
        else {
            $encoder = new BCryptPasswordEncoder(12);
            $password = $request->get('password');
            $prenom = $request->get('prenom');
            $tel = $request->get('tel');
            $birthday = $request->get('datedenaissance');
            $hashedpass = $encoder->encodePassword($password, null);
            $imagename = $_FILES["image"]["name"];
            $em = $this->getDoctrine()->getManager();
            $q = "Insert Into fos_user (username, username_canonical, email, email_canonical, enabled,password, roles,prenom, tel,
                         image, datedenaissance, registrationdate ,nbroffre, points)  VALUES (:username, :username, :email, :email, 1,:password, 'a:0:{}',:prenom, :tel,
                         :image, :datedenaissance, :registrationdate ,0, 0) ";
            $stmt = $em->getConnection()->prepare($q);
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':password', $hashedpass);
            $stmt->bindValue(':prenom', $prenom);
            $stmt->bindValue(':tel', $tel);
            $stmt->bindValue(':image', $imagename);
            $stmt->bindValue(':datedenaissance', date('Y-m-d', strtotime($birthday)));
            $stmt->bindValue(':registrationdate', date('Y-m-d'));
            $result = $stmt->execute();
            $appPath = $this->container->getParameter('kernel.root_dir');
            $webPath = realpath($appPath . '/../web/uploads/profiles');
            move_uploaded_file($_FILES["image"]["tmp_name"], $webPath . '/' . $_FILES["image"]["name"]);
            return new Response("Success");
        }

    }

    /**
     * @Route("/updateUserMobile", methods={"POST"})
     */
    public function updateUserMobileAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user2 = null;
        $encoder = new BCryptPasswordEncoder(12);
        $password = $request->get('password');
        $prenom = $request->get('prenom');
        $tel = $request->get('tel');
        $birthday = $request->get('datedenaissance');
        $em = $this->getDoctrine()->getManager();
        if ($password !='')
        {
            $hashedpass = $encoder->encodePassword($password, null);
            $qb = $em->createQuery("Update AppBundle:User u SET 
            u.password= :password, u.prenom = :prenom, u.tel= :tel, u.datedenaissance = :birthday
            WHERE u.username = :username")
            ->setParameters(array('username'=>$user->getUsername(), 'password'=>$hashedpass,'prenom'=>$prenom,'tel'=>$tel, 'birthday'=>date('Y-m-d', strtotime($birthday))))
            ->execute();
        }
        else
        {
            $qb = $em->createQuery("Update AppBundle:User u SET 
            u.prenom = :prenom, u.tel= :tel, u.datedenaissance = :birthday WHERE u.username = :username")
                ->setParameters(array('username'=>$user->getUsername(),'prenom'=>$prenom,'tel'=>$tel, 'birthday'=>date('Y-m-d', strtotime($birthday))))
                ->execute();
        }
        if (sizeof($_FILES) > 0)
        {
            $imagename = $_FILES["image"]["name"];
            $appPath = $this->container->getParameter('kernel.root_dir');
            $webPath = realpath($appPath . '/../web/uploads/profiles');
            move_uploaded_file($_FILES["image"]["tmp_name"], $webPath . '/' . $_FILES["image"]["name"]);
        }

        $normalizer = new ObjectNormalizer ();
        $normalizer->setCircularReferenceHandler(function ($user) {
            return $user->getId();
        });
        $user_manager = $this->get('fos_user.user_manager');
        $user2 = $this->getDoctrine()->getRepository(User:: class)->findOneBy(array('username' => $user->getUsername()));
        $user2->setDatedenaissance($user2->getDatedenaissance()->format('Y-m-d'));
        $serializer = new Serializer([$normalizer]);
        $formatted = $serializer->normalize($user2, null, [ObjectNormalizer::ATTRIBUTES => ['id', 'username', 'email', 'datedenaissance', 'image', 'nbroffre', 'points', 'prenom', 'tel','roles']]);
        return new JsonResponse($formatted);
    }


    public function getUserProfilePictureAction(Request $request)
    {
        $user_manager = $this->get('fos_user.user_manager');
        //$user = $user_manager->findUserByUsername($username);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $appPath = $this->container->getParameter('kernel.root_dir');
        $webPath = realpath($appPath . '/../web/uploads/profiles');
        $imagePath = $webPath . '/' . $user->getImage();

        /*
        $response = new Response();
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $user->getImage());
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/png');
        $response->setContent(file_get_contents($imagePath));
        */
        $response = new BinaryFileResponse($imagePath);

        return $response;
    }

    public function sendVerifCodeAction(Request $request)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $email = urldecode($request->get('email'));
        $user = $user_manager->findUserByEmail($email);
        if ($user != null) {
            $text = "Your Verification code is: " . $request->get('code');
            $message = \Swift_Message::newInstance()->setSubject('Your verification code')->setFrom('fithnitekcodeslayers@gmail.com')
                ->setTo($email)->setBody($text);
            $this->get('mailer')->send($message);
            return new Response("Sent");
        }
        else
            return new Response("No such user");
    }

    public function modifyPasswordAction(Request $request)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $email = urldecode($request->get('email'));
        $password = $request->get('password');
        $user = $user_manager->findUserByEmail($email);
        $encoder = new BCryptPasswordEncoder(12);
        $hashedpass = $encoder->encodePassword($password, null);
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQuery("Update AppBundle:User u SET 
            u.password= :password
            WHERE u.email = :email")
            ->setParameters(array('password'=>$hashedpass,'email'=>$email))
            ->execute();
        return new Response("Done");
    }

}