<?php
/**
 * RecordRepository.php
 *
 * @author leo@soulou.fr
 * @date 04/28/2012
 * @package Unsapa\IPWBundle\Repository
 */
namespace Unsapa\IPWBundle\Repository;

use Unsapa\IPWBundle\Entity\User;
use Unsapa\IPWBundle\Entity\Exam;

use Doctrine\ORM\EntityRepository;

/**
 * Override the normal entity repository to add functionalities
 */
class RecordRepository extends EntityRepository
{
  /**
   * Search with the composed primary key (Object)
   * @param Exam $exam
   * @param User $student
   */
  public function findByExamAndStudent(Exam $exam, User $student)
  {
    $query = $this->getEntityManager()
                  ->createQuery("SELECT re FROM UnsapaIPWBundle:Record re WHERE re.exam = :exam AND re.student = :student")
                  ->setParameters(array("exam" => $exam, "user" => $student))
                  ->getResult();
    return count($query) == 1 ? $query[0] : FALSE;
  }

  /**
   * Search with the composed primary key (Id)
   * @param $examid
   * @param $studentid
   */
  public function findByExamAndStudentId($examid, $studentid)
  {
    $query = $this->getEntityManager()
                  ->createQuery("SELECT re FROM UnsapaIPWBundle:Record re JOIN re.exam e JOIN re.student s WHERE e.id = :examid AND s.id = :studentid")
                  ->setParameters(array("examid" => $examid, "studentid" => $studentid))
                  ->getResult();
    return count($query) == 1 ? $query[0] : FALSE;
  }
}

?>
