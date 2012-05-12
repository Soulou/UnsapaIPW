<?php

namespace Unsapa\IPWBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundException;

use Unsapa\IPWBundle\Helper\ExamCheckHelper;
use Unsapa\IPWBundle\Entity\Exam;

/**
 * Manage how students attend to the exams
 */
class RecordController extends Controller
{
  /**
   * Return the ajax object of the record
   *
   * @param $examid Id of the exam we want the record (with the current user)
   */ 
  public function fromExamAction($examid)
  {
    $user = $this->get('security.context')->getToken()->getUser();
    $exam = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Exam")->find($examid);
    ExamCheckHelper::securityCheckExam($exam, $user);

    $record = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Record")->findByExamAndStudentId($examid, $user->getId());
    if(!$record)
      throw new NotFoundException();
  
   // ToString of Record return JSON representation of the object
   return new Response($record);
  }  
}

?>
