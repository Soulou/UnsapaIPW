<?php

namespace Unsapa\IPWBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ApplicationController extends Controller
{
    public function indexAction()
    {
        return $this->render('UnsapaIPWBundle:Application:index.html.twig');
    }
}
