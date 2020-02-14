<?php

namespace FiThnitekBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@FiThnitek/FiThnitek/index.html.twig');
    }

    public function adminAction()
    {
        return $this->render('@FiThnitek/FiThnitek/backend.html.twig');
    }
}
