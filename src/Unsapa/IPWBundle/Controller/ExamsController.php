<?php

namespace Unsapa\IPWBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExamsController extends Controller
{
    public function indexAction()
    {
      $exams = $this->getDoctrine()
        ->getRepository('UnsapaIPWBundle:Record')
        ->findAll();

      return $this->render('UnsapaIPWBundle:Exams:index.html.twig', array('exams' => $exams));
    }
}
