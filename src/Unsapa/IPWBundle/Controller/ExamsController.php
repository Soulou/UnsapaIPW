<?php

namespace Unsapa\IPWBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Unsapa\IPWBundle\Entity\Record;
use Unsapa\IPWBundle\Entity\Exam;

class ExamsController extends Controller
{
    public function addAction(Request $request)
    {
      $exam = new Exam();
      $form = $this->createFormBuilder($exam)
        ->add('title', 'text', array('label' => "Titre : "))
        ->add('promo', 'entity', array(
            'label' => "Promotion : ", 
            'class' => "UnsapaIPWBundle:Promo",
            'property' => "name",
            'query_builder' => 
              function(EntityRepository $er) {
                return $er->createQueryBuilder('p')->orderBy('p.name', 'ASC');
              }
            )
          )
        ->add('exam_desc','textarea', array('label' => "Description : ", 'required' => false))
        ->add('exam_date', 'date', array('widget'=>'single_text', 'label' => "Échéance : "))
        ->add('coef', 'number', array('label' => "Coefficient : "))
        ->getForm();

      if($request->getMethod() == "POST")
      {
        $form->bindRequest($request);
        

        if($form->isValid());
        {
          $exam->setResp($this->get('security.context')->getToken()->getUser());
          $exam->setState("PENDING");
          $manager = $this->get('doctrine')->getEntityManager();
          $manager->persist($exam);
          $manager->flush();

          $users = $this->get('doctrine')
            ->getRepository("UnsapaIPWBundle:User")
            ->findByPromo($request->get('promo'));

          foreach($users as $user)
          {
            $record = new Record();
            $record->setStudent($user);
            $record->setExam($exam);
            $manager->persist($exam);
            $manager->flush();
          }
          return $this->redirect($this->generateUrl('exams'), 201);
        }
      }
      else
      {
        return $this->render('UnsapaIPWBundle:Exams:add.html.twig', array('exam' => $exam, 'form' => $form->createView()));
      }
    }
    public function indexAction()
    {
      $user = $this->get('security.context')->getToken()->getUser();
      if($this->get('security.context')->isGranted("ROLE_TD"))
      {
        $exams = $this->getDoctrine()
          ->getRepository('UnsapaIPWBundle:Exam')
          ->findByResp($user);
          return $this->render('UnsapaIPWBundle:Exams:index.html.twig', array('exams' => $exams));
      }
      else
      {
        $records = $this->getDoctrine()
          ->getRepository('UnsapaIPWBundle:Record')
          ->findByStudent($user);
        return $this->render('UnsapaIPWBundle:Exams:index.html.twig', array('records' => $records));
      }
    }
}
