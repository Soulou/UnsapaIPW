<?php
/**
 * ExamsController.php
 *
 * @date 04/25/2012
 * @package Unsapa\IPWBundle\Controller
 */

namespace Unsapa\IPWBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

use Unsapa\IPWBundle\Form\Type\ExamType;
use Unsapa\IPWBundle\Entity\Record;
use Unsapa\IPWBundle\Entity\Exam;

/**
 * Define actions of the entity Exam
 */
class ExamsController extends Controller
{
    /**
     * When a td resp wants to add an exam
     * Route /exams/add 
     */
    public function addAction()
    {
      $exam = new Exam();
      $exam->setResp($this->get('security.context')->getToken()->getUser());
      $exam->setState("PENDING");
      $form = $this->createForm(new ExamType(), $exam);

      if($this->getRequest()->getMethod() == "POST")
      {
        try
        {
          $form->bindRequest($this->getRequest());
          $error_date = false;
        } catch (\ErrorException $e)
        {
          if($form->has("exam_date"))
          {
            $child = $form->get("exam_date");
            $child->addError(new FormError("La date n'est pas valide"));
            $error_date = true;
          }
        }

        if(!$error_date && $form->isValid())
        {
          $manager = $this->get('doctrine')->getEntityManager();
          $manager->persist($exam);
          $manager->flush();

          $keys = $this->getRequest()->request->keys();
          $users = array();
          for($i = 0; $i < count($keys); $i++)
          {
            if(substr($keys[$i], 0, 4) == "user")
            {
              $id = substr($keys[$i], 4);
              $user = $this->getDoctrine()->getRepository("UnsapaIPWBundle:User")->find($id);
              if($user)
              {
                array_push($users, $user);
              }
            }
          }

          if(count($users) == 0)
          {
            $users = $this->get('doctrine')
              ->getRepository("UnsapaIPWBundle:User")
              ->findByPromo($exam->getPromo());
          }

          foreach($users as $user)
          {
            $record = new Record();
            $record->setStudent($user);
            $record->setExam($exam);
            $manager->persist($record);
            $manager->flush();
          }
          return $this->redirect($this->generateUrl('exams'), 301);
        }
      }
      return $this->render('UnsapaIPWBundle:Exams:add.html.twig', array('exam' => $exam, 'form' => $form->createView()));
    }

    /**
     * When a student wants add a document to an exam he's concerned with
     * Route /exams/submit
     */
    public function submitAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        // We prepare a query_builder to get the records of the 
        // current user with the state "PENDING"
        $record = new Record();
        $record->setStudent($user);
  
        $qb = $this->getDoctrine()->getEntityManager()
          ->createQueryBuilder()
          ->select('e')
          ->from('UnsapaIPWBundle:Exam', 'e')
          ->innerJoin('e.records', 'r')
          ->where('r.student = :user and e.state = :state')
          ->setParameters(array('user' => $user, 'state' => 'PENDING'))
          ->orderBy('e.title', 'ASC');

        $form = $this->createFormBuilder($record)
          ->add('exam', 'entity', array(
              'label' => "Examen : ", 
              'class' => "UnsapaIPWBundle:Exam",
              'property' => "title",
              'query_builder' => $qb
            ))
          ->add('file','file', array('label' => "Fichier : "))
          ->getForm();

        if($this->getRequest()->getMethod() === 'POST')
        {
            $form->bindRequest($this->getRequest());

            if($form->isValid())
            {
                $exam = $record->getExam();
                $em = $this->getDoctrine()->getEntityManager();
                $real_record = $em
                  ->createQuery("SELECT r FROM UnsapaIPWBundle:Record r WHERE r.exam = :exam AND r.student = :user")
                  ->setParameters(array("exam" => $exam, "user" => $user))
                  ->setMaxResults(1)
                  ->getResult();

                $real_record[0]->setFile($record->getFile());
                $real_record[0]->setDocument($real_record[0]->getDocumentName());
                $em->persist($real_record[0]);
                $em->flush();
                return $this->redirect($this->generateUrl('exams'), 301);
            }
        }
        return $this->render('UnsapaIPWBundle:Exams:submit.html.twig', array('form' => $form->createView()));
    }

    /**
     * Show details for a precise exam
     * @param integer $id Identifier of the exam
     */
    public function showAction($id)
    {
      $exam = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Exam")->find($id);
      
      if(!$exam)
      {
        throw $this->createNotFoundException('Cet examen n\'existe pas');
      }
      else
      {
          return $this->render("UnsapaIPWBundle:Exams:show.html.twig", array("exam" => $exam, "description" => $exam->getExamDesc(), "date" => $exam->getExamDate(), "coeff"  => $exam->getCoef(), "promo"  => $exam->getPromo(), "resp"  => $exam->getResp() ));
      }
    }

    /**
     * Show the details to the exams the user is concerned with
     * For a Student it prints the exams he is concerned with
     * For a TD Manager, it prints the exams he is responsible
     */
    public function indexAction()
    {
      $user = $this->get('security.context')->getToken()->getUser();
      if($this->get('security.context')->isGranted("ROLE_TD"))
      {
        $exams = $this->getDoctrine()
          ->getRepository('UnsapaIPWBundle:Exam')
          ->findByResp($user);

        $exams_pending = array();
        $exams_ended = array();
        foreach($exams as $exam)
        {
          if($exam->getState() == "PENDING")
            array_push($exams_pending, $exam);
          if($exam->getState() == "FINISH")
            array_push($exams_ended, $exam);
        }
        return $this->render('UnsapaIPWBundle:Exams:index_td.html.twig',
          array('exams_pending' => $exams_pending, 'exams_ended' => $exams_ended));
      }
      else
      {
        $records = $this->getDoctrine()->getEntityManager()
          ->createQuery('SELECT r FROM UnsapaIPWBundle:Record r JOIN r.exam e WHERE r.student = :user ORDER BY e.exam_date')
          ->setParameter('user', $user)
          ->getResult();
        $records_pending = array();
        $records_ended = array();
        foreach($records as $record)
        {
          if($record->getExam()->getState() == "PENDING")
            array_push($records_pending, $record);
          if($record->getExam()->getState() == "FINISH")
            array_push($records_ended, $record);
        }

        return $this->render('UnsapaIPWBundle:Exams:index_student.html.twig', 
          array('records_pending' => $records_pending, 'records_ended' => $records_ended));
      }
    }
}
