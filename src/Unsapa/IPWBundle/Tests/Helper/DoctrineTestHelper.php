<?php
/**
 * DoctrineTestHelper.php
 *
 * @author leo@soulou.fr
 * @package Unsapa\IPWBundle\Tests\Helper
 */

namespace Unsapa\IPWBundle\Tests\Helper;

use Doctrine\ORM\Tools\SchemaTool;

/**
 * Some functions to use when testing persistency
 */
class DoctrineTestHelper
{
  /*
   * Kernel of the application
   * @var HttpKernelInterface $kernel
   */
  private $kernel;

  /*
   * EntityManager of Doctrine
   * @var EntityManager $em
   */
  private $em;

  /**
   * FOSUserBundle UserManager
   * @var UserManager $um
   */
  protected $um;

  /*
   * Validator of Symfony
   * @var Validator $validator
   */
  private $validator;

  /**
   * Main constructor
   * @param HttpKernelInterface $kernel Kernel of the application
   */
  public function __construct($kernel)
  {
    if($kernel == NULL)
      throw new \ErrorException("Kernel is null");

    $this->kernel = $kernel;
    $this->em = DoctrineTestHelper::getEntityManager();
    $this->em = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
    $this->um = $this->kernel->getContainer()->get('fos_user.user_manager');
    $this->validator = $this->kernel->getContainer()->get('validator');
  }

  /**
   * Drop all the content, and reset the schema of the test database
   */
  public function resetDatabase()
  {
    $schema_manager = $this->em->getConnection()->getDriver()->getSchemaManager($this->em->getConnection());
    $schema_tool = new SchemaTool($this->em);
    $metadatas = $this->em->getMetadataFactory()->getAllMetadata();
    $schema_tool->dropSchema($metadatas);
    $schema_tool->createSchema($metadatas);
  }

  /**
   * Get the entity manager of doctrine
   * @return EntityManager Doctrine's entity manager
   */
  public function getEntityManager()
  {
    return $this->em;
  }

  /**
   * Get the current validator
   * @return Validator
   */
  public function getValidator()
  {
    return $this->validator;
  }

  /**
   * Get FOS UserManager
   * @return UserManager
   */
  public function getUserManager()
  {
    return $this->um;
  }
}
