<?php
/**
 * Sanity check about who can access an Exam
 * @package Unsapa\IPWBundle\Helper
 */

namespace Unsapa\IPWBundle\Helper;

use Unsapa\IPWBundle\Entity\Exam;
use Unsapa\IPWBundle\Entity\User;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundException;

/**
 * Helper to perform basical sanity check over exam entity
 */
class ExamCheckHelper
{
  /**
   * Perform different tests to see if the current user can modify the exam
   *
   * @param Exam $exam to check
   * @param User $user who wants to access the exam
   * @param string $function Name of the function which is using this helper
   */
  public static function securityCheckExam(Exam $exam, User $user, $function = NULL)
  {
    if(!$exam)
      throw new NotFoundException('Cet examen n\'existe pas');

    if(in_array("ROLE_TD", $user->getRoles()) && $exam->getResp() != $user)
      throw new AccessDeniedHttpException("Vous n'êtes pas responsable de cet examen.");

    if($function == "markAction")
    {
      if($exam->getExamDate() >= new \DateTime('now'))
      {
        throw new AccessDeniedHttpException("Vous ne pouvez noter cet examen, il est encore en cours.");
      }
    }
    else if($exam->getExamDate() < new \DateTime('now'))
      throw new AccessDeniedHttpException("Vous ne pouvez modifier cet examen, il est terminé.");
  }
}
