<?php

namespace Unsapa\IPWBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Unsapa\IPWBundle\Entity\Record;
use Unsapa\IPWBundle\Entity\Exam;
use Unsapa\IPWBundle\Entity\User;
use Unsapa\IPWBundle\Entity\Promo;

/**
 * Manage how students attend to the exams
 */
class AttendController extends Controller
{
  /**
   * When the form is posted, get the data and compare them to the database
   *
   * @param id ID of the current exam
   */
  public function examAttributeStudents($id)
  {
    $exam = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Exam")->find($id);
    $promo_users = $this->getDoctrine()->getRepository("UnsapaIPWBundle:User")->findByPromo($exam->getPromo());

    $students_id = $this->getRequest()->request->all();
    $selected_users = array();
    foreach($students_id as $student_id)
    {
      $user = $this->getDoctrine()->getRepository("UnsapaIPWBundle:User")->find($student_id);
      if($user->getPromo() != $exam->getPromo())
        throw new AccessDeniedHttpException("Vous n'avez pas manipuler cet utilisateur pour cet examen.");

      array_push($selected_users, $user);
    }
    $unselected_users = array_diff($promo_users, $selected_users);

    // We delete the corresponding records (students who don't attend anymore to the exam)
    $em = $this->getDoctrine()->getEntityManager();
    foreach($unselected_users as $user)
    {
      $record = $em
        ->createQuery("SELECT r FROM UnsapaIPWBundle:Record r WHERE r.exam = :exam AND r.student = :user")
        ->setParameters(array('exam' => $exam, 'user' =>$user))
        ->setMaxResults(1)
        ->getResult();
      if(count($record) == 1)
      {
        $em->remove($record[0]);
        $em->flush();
      }
    }
    // We add a new record to the users who didn't have one
    foreach($selected_users as $user)
    {
      $record = $em
        ->createQuery("SELECT r FROM UnsapaIPWBundle:Record r WHERE r.exam = :exam AND r.student = :user")
        ->setParameters(array('exam' => $exam, 'user' =>$user))
        ->setMaxResults(1)
        ->getResult();
      if(count($record) == 0)
      {
        $record = new Record();
        $record->setExam($exam);
        $record->setStudent($user);
        $em->persist($record);
        $em->flush();
      }
    }
  }

  /**
   * route : /exam/:id/students
   * Manage the students who attend an exam
   */
  public function examChoiceAction($id)
  {
    $exam = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Exam")->find($id);
    if(!$exam)
      throw $this->createNotFoundException('Cet examen n\'existe pas');

    if($exam->getResp() != $this->get('security.context')->getToken()->getUser())
      throw new AccessDeniedHttpException("Vous n'êtes pas responsable de cet examen.");

    if($exam->getExamDate() < new \DateTime('now'))
      throw new AccessDeniedHttpException("Vous ne pouvez modifier cet exam, il est terminé.");

    if($this->getRequest()->getMethod() == "POST")
    {
      $this->examAttributeStudents($id);
      return $this->redirect($this->generateUrl('exams'), 301);
    }

    $records = $exam->getRecords();

    $promo_users = $this->getDoctrine()->getRepository("UnsapaIPWBundle:User")->findByPromo($exam->getPromo());
    $exam_users = array();
    foreach($records as $record)
    {
      array_push($exam_users, $record->getStudent());
    }
    $not_exam_users = array_diff($promo_users, $exam_users);

    return $this->render("UnsapaIPWBundle:Attend:exam_choice.html.twig", 
      array('exam_users' => $exam_users, 'not_exam_users' => $not_exam_users, 'exam' => $exam));
  }
}

?>
