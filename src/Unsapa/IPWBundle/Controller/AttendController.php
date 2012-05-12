<?php

namespace Unsapa\IPWBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;

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
   * Perform different tests to see if the current user can modify the exam
   *
   * @param $exam to check
   */
  protected function securityCheckExam($exam)
  {
    if(!$exam)
      throw $this->createNotFoundException('Cet examen n\'existe pas');

    if($exam->getResp() != $this->get('security.context')->getToken()->getUser())
      throw new AccessDeniedHttpException("Vous n'êtes pas responsable de cet examen.");

    if($exam->getExamDate() < new \DateTime('now'))
      throw new AccessDeniedHttpException("Vous ne pouvez modifier cet exam, il est terminé.");
  }

  /**
   * When the form is posted, get the data and compare them to the database
   *
   * @param $id ID of the current exam
   */
  protected function examAttributeStudents($id)
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
   * @param $id ID of the current exam
   */
  public function examChoiceAction($id)
  {
    $exam = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Exam")->find($id);
    $this->securityCheckExam($exam);

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

    return $this->render("UnsapaIPWBundle:Attend:choice.html.twig", 
      array('exam_users' => $exam_users, 'not_exam_users' => $not_exam_users, 'exam' => $exam));
  }

  /**
   * When a user post /exams/:id/mark we modify the mark of the students
   *
   * @param $exam concerned exam
   */
  protected function markStudents($exam)
  {
    $student_ids = $this->getRequest()->request->keys();
    $em = $this->getDoctrine()->getEntityManager();
    for($i = 0; $i < count($student_ids); $i++)
    {
      $record = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Record")->findByExamAndStudentId($exam->getId(), $student_ids[$i]);
      if($record === NULL)
        throw $this->createNotFoundException("Étudiant inexistant.");

      $mark = floatval($this->getRequest()->request->get($student_ids[$i]));
      if(empty($mark))
        $record->setMark(NULL);
      else
        $record->setMark($mark);

      echo $this->getRequest()->request->get($student_ids[$i]);

      $validator = $this->get('validator');
      $errors = $validator->validate($record);
      if(count($errors) > 0)
        return new Response(print_r($errors, true));

      $em->persist($record);
      $em->flush();
    }
  }

  /**
   * route : /exam/:id/students
   * Manage the students who attend an exam 
   * @param $id ID of the current exam
   */
  public function markAction($id)
  {
    $exam = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Exam")->find($id);
    $this->securityCheckExam($exam);

    if($this->getRequest()->getMethod() == "POST")
      $this->markStudents($exam);

    $records = $this->getDoctrine()->getEntityManager()
      ->createQuery("SELECT r FROM UnsapaIPWBundle:Record r WHERE r.exam = :exam AND r.document IS NOT NULL")
      ->setParameter('exam', $exam)
      ->getResult();
    
    return $this->render("UnsapaIPWBundle:Attend:mark.html.twig", array('records' => $records, 'exam' => $exam)); 
  }

  /**
   * route : /download/:userid/:examid
   * Download the file uploaded by the user 
   * @param userid parameter of the record id
   * @param examid 2nd parameter of the record id
   */
  public function downloadAction($userid, $examid)
  {
    $current_user = $this->get('security.context')->getToken()->getUser();
    $record = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Record")->findByExamAndStudentId($examid, $userid);
    if(!$current_user || !$record || ($userid != $current_user->getId() && $current_user != $record->getExam()->getResp()))
      throw $this->createNotFoundException("Fichier inconnu");

    $filename = $record->getDocumentAbsolutePath();
    $record->setFile(new File($filename));

    $r = new Response();
    $r->setStatusCode(200);
    $r->headers->set('Content-Type', $record->getFile()->getMimeType());
    $r->headers->set('Content-Transfer-Encoding', 'binary');
    $r->headers->set('Content-Disposition', 'attachment;filename=' 
      . $record->getStudent()->getFirstName()
      . $record->getStudent()->getLastName()
      . $record->getExam()->getTitle() . "."
      . $record->getFile()->getExtension()
    );
    $r->headers->set('Content-Length', filesize($filename));
    $r->setContent(file_get_contents($filename));
    $r->send();

    return $r;
  }
}

?>
