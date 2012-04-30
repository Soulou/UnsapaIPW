<?php

namespace Unsapa\IPWBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExamsController extends Controller
{
    public function indexAction()
    {
      $user = $this->get('security.context')->getToken()->getUser();
      $exams = $this->getDoctrine()
        ->getRepository('UnsapaIPWBundle:Record')
        ->findByUser($user);

      return $this->render('UnsapaIPWBundle:Exams:index.html.twig', array('exams' => $exams));
    }
}
