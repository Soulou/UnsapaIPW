<?php
/**
 * UnsapaTest.php
 * @package Unsapa\IPWBundle\Tests
 */

namespace Unsapa\IPWBundle\Tests;

use Unsapa\IPWBundle\Entity\Exam;
use Unsapa\IPWBundle\Entity\Promo;
use Unsapa\IPWBundle\Entity\User;
use Unsapa\IPWBundle\Entity\Record;
use Unsapa\IPWBundle\Tests\Helper\DoctrineTestHelper;

use Symfony\Component\Validator\Validator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Setup Doctrine and add some functions
 */
class UnsapaTest extends WebTestCase
{
  /**
   * Doctrine EntityManager
   * @var EntityManager $em
   */
  protected $em;
  /**
   * FOSUserBundle UserManager
   * @var UserManager $um
   */
  protected $um;
  /**
   * Browser client for functional testing
   * @var Client $client
   */
  protected $client;
  /**
   * Validator to validate entities
   * @var Validator $validator
   */
  protected $validator;

  /**
   * Initialize Doctrine
   * Destroy/Create Database Schema
   */
  public function setUp()
  {
    $client = $this->createClient();
    $dth = new DoctrineTestHelper(static::$kernel);
    $dth->resetDatabase();
    $this->em = $dth->getEntityManager();
    $this->um = $dth->getUserManager();
    $this->validator = $dth->getValidator();
  }

  /**
   * Create a sample promo
   * @param string $name Name of the sample promotion
   * @return Promo The persistant promotion
   */
  protected function createPromo($name = "PromoTest")
  {
    $promo = new Promo();
    $promo->setName($name);

    $this->validate($promo);
    $this->em->persist($promo);
    $this->em->flush();

    return $promo;
  }

  /**
   * Create a sample TD manager
   * @param array $params Username/Email of the sample tduser
   * @return User The persistant TDuser
   */
  protected function createRespTD($params = array('username' => "TDTest", 'email' => "test@example.com"))
  {
    $td = $this->createStudent($params);
    $td->addRole("ROLE_TD");
    $td->setFirstname("Tduser");
    $td->setLastname("Test");

    $this->validate($td);
    $this->em->persist($td);
    $this->em->flush();

    return $td;
  }

  /**
   * Create a sample student
   * @param array $params Username\Email of the sample student
   * @return User The persistant student
   */
  protected function createStudent($params = array('username' => "StudentTest", 'email' => "user@example.com"))
  {
    $st = $this->um->createUser();
    $st->initUser(array(
      'username' => $params['username'],
      'email' => $params['email'],
      'password' => "passwd",
      'firstname' => "Test",
      'lastname' => "User"
    ));

    $this->validate($st);
    $this->em->persist($st);
    $this->em->flush();

    return $st;
  }

  /**
   * Create a new Exam for testing
   * @param Datetime $date
   * @param Promo $promo
   * @param User $resp
   * @return Exam We want a new instance in each test.
   */
  protected function createExam($promo, $resp, $date = NULL)
  {
    if($date == NULL)
      $date = new \Datetime('now');
    $exam = new Exam(array(
      'title' => "ExamTest",
      'promo' => $promo,
      'exam_date' => $date,
      'exam_desc' => "ExamDesc",
      'resp' => $resp,
      'coef' => 1.));
    $this->validate($exam);
    $this->em->persist($exam);
    $this->em->flush();
    return $exam;
  }

  /**
   * Create a new Record for testing
   * @param array $values Values of the record parameter
   * @return The persistant record
   */
  protected function createRecord(array $values)
  {
    $record = new Record($values);
    $this->validate($record);
    $this->em->persist($record);
    $this->em->flush();
    return $record;
  }

  /**
   * Validate the Object and print the errors
   * @param Entity $o
   */
  protected function validate($o)
  {
    $errors = $this->validator->validate($o);
    if($errors->count() > 0)
      throw new \InvalidArgumentException($errors->__toString());
  }

  /** 
   * Test to avoir warning
   */
  public function testPass()
  {
    $this->assertTrue(TRUE);
  }
}
