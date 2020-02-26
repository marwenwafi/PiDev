<?php

namespace FiThnitekBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@FiThnitek/FiThnitek/index.html.twig');
    }
    public function backAction()
    {
        return $this->render('@FiThnitek/FiThnitekBack/index.html.twig');
    }

    public function loginAction()
    {
        return $this->render('@FiThnitek/FiThnitek/login.html.twig');
    }

    public function RegisterAction()
    {
        return $this->render('@FiThnitek/FiThnitek/register.html.twig');
    }

    public function afficheAction()
    {
        return $this->render('@FiThnitek/FiThnitek/affiche.html.twig');
    }

}
