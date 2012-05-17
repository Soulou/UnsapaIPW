<?php
/**
 * Testing the Exam Entity
 * @package Unsapa\IPWBundle\Tests\Entity
 */
namespace Unsapa\IPWBundle\Tests\Entity;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Unsapa\IPWBundle\Entity\Exam;
use Unsapa\IPWBundle\Entity\Promo;
use Unsapa\IPWBundle\Entity\User;

/**
 * { @inheritdoc }
 * @see Unsapa\IPWBundle\Entity\Exam
 */
class ExamsTest extends WebTestCase
{
  /**
   * Doctrine EntityManager
   */
  private $em;
  /**
   * Browser client for functional testing
   */
  private $client;
  /**
   * Sample Promo for the tests
   */
  private $promo;
  /**
   * Sample TD for the tests
   */
  private $td;

  /**
   * Create the sample promo
   */
  private function createPromo()
  {
    $this->promo = new Promo();
    $this->promo->setName("PromoTest");
    $this->em->persist($this->promo);
    $this->em->flush();
  }

  /**
   * Create the sample TD manager
   */
  private function createRespTD()
  {
    $this->td = new User();
    $this->td->setUsername("UserTest");
    $this->td->setEmail("test@example.com");
    $this->td->setPassword("passwd");
    $this->td->setRoles(array("ROLE_STUDENT", "ROLE_TD"));

    $this->em->persist($this->td);
    $this->em->flush();
  }

  /**
   * Initialize Doctrine
   * Destroy/Create Database Schema
   */
  public function setUp()
  {
    $client = $this->createClient();
    $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    $schema_manager = $this->em->getConnection()->getDriver()->getSchemaManager($this->em->getConnection());
    $schema_tool = new SchemaTool($this->em);
    $metadatas = $this->em->getMetadataFactory()->getAllMetadata();
    $schema_tool->dropSchema($metadatas);
    $schema_tool->createSchema($metadatas);

    $this->createPromo();
    $this->createRespTD();
  }

  /**
   * Check that in a new exam, all the fields are NULL by default
   */
  public function testNewExam()
  {
    $exam = new Exam();
    $this->assertNull($exam->getId());
    $this->assertNull($exam->getTitle());
    $this->assertNull($exam->getExamDesc());
    $this->assertNull($exam->getExamDate());
    $this->assertNull($exam->getCoef());
    $this->assertNull($exam->getPromo());
  }

  /**
   * We can't save an empty exam
   * @expectedException PDOException
   */
  public function testSaveEmptyExam()
  {
    $exam = new Exam();
    $this->em->persist($exam);
    $this->em->flush();
  }

  /**
   * With the correct information, it saves correctly
   */
  public function testSaveFillExam()
  {
    $exam = new Exam();
    $exam->setTitle("ExamTest");
    $exam->setPromo($this->promo);
    $exam->setExamDate(new \DateTime('now'));
    $exam->setCoef(1);
    $exam->setState("PENDING");
    $this->em->persist($exam);
    $this->em->flush();

    $this->assertRegExp('/[0-9]+/', $exam->getId() . "");
  }
}
