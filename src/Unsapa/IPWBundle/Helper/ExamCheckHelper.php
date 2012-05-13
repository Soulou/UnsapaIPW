<?php

namespace Unsapa\IPWBundle\Helper;

use Unsapa\IPWBundle\Entity\Exam;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundException;

class ExamCheckHelper
{
  /*
   * Perform different tests to see if the current user can modify the exam
   *
   * @param $exam to check
   */
  public static function securityCheckExam($exam, $user)
  {
    if(!$exam)
      throw new NotFoundException('Cet examen n\'existe pas');

    if(in_array("ROLE_TD", $user->getRoles()) && $exam->getResp() != $user)
      throw new AccessDeniedHttpException("Vous n'êtes pas responsable de cet examen.");

    if($exam->getExamDate() < new \DateTime('now'))
      throw new AccessDeniedHttpException("Vous ne pouvez modifier cet exam, il est terminé.");
  }
}
