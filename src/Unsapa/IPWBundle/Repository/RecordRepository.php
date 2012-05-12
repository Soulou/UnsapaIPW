<?php
namespace Unsapa\IPWBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RecordRepository extends EntityRepository
{
  public function findByExamAndStudent($exam, $student)
  {
    $query = $this->getEntityManager()
                  ->createQuery("SELECT re FROM UnsapaIPWBundle:Record re WHERE re.exam = :exam AND re.student = :student")
                  ->setParameters(array("exam" => $exam, "user" => $student))
                  ->getResult();
    return $query[0];
  }

  public function findByExamAndStudentId($examid, $studentid)
  {
    $query = $this->getEntityManager()
                  ->createQuery("SELECT re FROM UnsapaIPWBundle:Record re JOIN re.exam e JOIN re.student s WHERE e.id = :examid AND s.id = :studentid")
                  ->setParameters(array("examid" => $examid, "studentid" => $studentid))
                  ->getResult();
    return $query[0];
  }
}

?>
