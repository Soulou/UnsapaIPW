<?php

namespace Unsapa\IPWBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Unsapa\IPWBundle\Entity\Exam;

class ExamsController extends Controller
{
    public function addAction()
    {
      $exam = new Exam();
      $request = $this->getRequest();
      if(count($request->request) != 0)
      {
        $validator = $this->get('validator');

        $promo = $this->getDoctrine()
          ->getRepository('UnsapaIPWBundle:Promo')
          ->findOneByName($request->get('name'));

        $exam->setTitle($request->get('title'));
        $exam->setPromo($promo);
        $exam->setExamDesc($request->get('desc'));
        $exam->setExamDate(new \DateTime($request->get('date')));
        $exam->setCoef($request->get('coef'));
        $exam->setResp($this->get('security.context')->getToken()->getUser());

        $errors = $validator->validate($exam);

        if (count($errors) > 0)
          return new Response(print_r($errors, true));
        else
        {
          $manager = $this->get('doctrine')->getEntityManager();
          $manager->persist($exam);
          $manager->flush();
          return $this->redirect($this->generateUrl('exams'), 201);
        }
      }
      else
      {
        $promos = $this->getDoctrine()
          ->getRepository('UnsapaIPWBundle:Promo')
          ->findAll();
        return $this->render('UnsapaIPWBundle:Exams:add.html.twig', array('promos' => $promos,'exam' => $exam));
      }
    }
    public function indexAction()
    {
      $user = $this->get('security.context')->getToken()->getUser();
      $records = $this->getDoctrine()
        ->getRepository('UnsapaIPWBundle:Record')
        ->findByStudent($user);

      return $this->render('UnsapaIPWBundle:Exams:index.html.twig', array('exam' => $records));
    }
}
