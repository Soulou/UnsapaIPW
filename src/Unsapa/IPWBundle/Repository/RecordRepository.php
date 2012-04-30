<?php
namespace Unsapa\IPWBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RecordRepository extends EntityRepository
{
  public function findByUser($user)
  {
    $id = $user->getId();
    $query = $this->getEntityManager()
                  ->createQuery("SELECT re FROM UnsapaIPWBundle:Record re JOIN re.student u WHERE u.id = :id")
                  ->setParameter("id", $id)
                  ->getResult();
    return $query;
  }
}

?>
