<?php
/**
 * Testing the Exam Entity
 * @package Unsapa\IPWBundle\Tests\Entity
 */
namespace Unsapa\IPWBundle\Tests\Entity;

use Unsapa\IPWBundle\Tests\UnsapaTest;

use Unsapa\IPWBundle\Entity\Exam;
use Unsapa\IPWBundle\Entity\Promo;
use Unsapa\IPWBundle\Entity\User;
use Unsapa\IPWBundle\Entity\Record;

/**
 * Tests the entity Exam
 * @see Unsapa\IPWBundle\Entity\Exam
 */
class ExamsTest extends UnsapaTest
{
  /**
   * Sample Promo for the tests
   * @var Promo $promo
   */
  private $promo;
  /**
   * Sample TD for the tests
   * @var User $td
   */
  private $td;
  /**
   * Sample Date for th tests
   * @var DateTime $date
   */
  private $date;

  public function setUp()
  {
    parent::setUp();

    $this->promo = $this->createPromo();
    $this->td = $this->createRespTD();
    $this->date = (new \DateTime('now'))->add(new \DateInterval("P1D"));
  }

  /**
   * Check that in a new exam, all the fields are NULL by default
   */
  public function testNewExam()
  {
    $exam = new Exam();

    $this->assertNull($exam->getId(), "Id is NULL");
    $this->assertNull($exam->getTitle(), "Title is NULL:");
    $this->assertNull($exam->getExamDesc(), "Exam Description is NULL");
    $this->assertNull($exam->getExamDate(), "Exam date is NULL");
    $this->assertNull($exam->getCoef(), "Exam coef is NULL");
    $this->assertNull($exam->getPromo(), "Promo is NULL");
    $this->assertNull($exam->getResp(), "Resp is NULL");
  }

  /**
   * We can't save an empty exam
   * @expectedException PDOException
   * @exceptedExceptionMessage Impossible to save an empty Exam
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
  public function testPersistExam()
  {
    $exam = $this->createExam($this->promo, $this->td, $this->date);

    $query = $this->em->createQuery("SELECT COUNT(e) FROM UnsapaIPWBundle:Exam e");
    $this->assertEquals(1, $query->getSingleScalarResult(), "Fetch only one result");

    $query = $this->em->createQuery("SELECT e FROM UnsapaIPWBundle:Exam e");
    $exam = $query->getResult();

    $this->assertCount(1, $exam, "We want 1 result");
    $exam = $exam[0];

    $this->assertEquals("ExamTest", $exam->getTitle(), "The title is ExamTest");
    $this->assertEquals($this->promo, $exam->getPromo(), "The promo is the same");

    $this->assertGreaterThanOrEqual((new \Datetime('now')), $exam->getExamDate(), "The date of the exam is equal or superior of the actual date");
    $this->assertEquals($this->date, $exam->getExamDate(), "The initial date and the query result date are identical");

    $this->assertEquals("ExamDesc", $exam->getExamDesc(), "Description is equal");
    $this->assertEquals(1., $exam->getCoef(), "Coefficient is equal");
    $this->assertEquals($this->td, $exam->getResp(), "TD teacher is equal");
  }

  /** 
   * Test getFormatExamDate method
   */
  public function testGetFormatExamDate()
  {
    $exam = $this->createExam($this->promo, $this->td, $this->date);
    // Format : Monday 20 September 2012
    $this->assertEquals(
      ucfirst(strftime("%A %d %B %G", $exam->getExamDate()->getTimestamp())), 
      $exam->getFormatExamDate(),
      "Format date is correct"
    );
  }

  /**
   * Test getSmallFormatExamDate method
   */
  public function testGetSmallFormatExamDate()
  {
    $exam = $this->createExam($this->promo, $this->td, $this->date);
    // Format : Monday 20 September 2012
    $this->assertEquals(
      strftime("%d/%m/%G", $exam->getExamDate()->getTimestamp()), 
      $exam->getSmallFormatExamDate(),
      "Small Format date is correct"
    );
  }

  /**
   * Test __toString method
   */
  public function testToString()
  {
    $exam = $this->createExam($this->promo, $this->td, $this->date);
    // To string get the title
    $this->assertEquals("ExamTest", $exam->__toString());
  }

  /**
   * Test setters
   */
  public function testSetters()
  {
    $newDate = new \DateTime('now');
    $newPromo = $this->createPromo("NewPromo");
    $newTd = $this->createRespTD(array('username' => "NewTD", 'email' => "newtd@example.com"));

    $exam = $this->createExam($this->promo, $this->td, $this->date);
    $exam->setTitle("NewTitle");
    $exam->setExamDesc("NewDesc");
    $exam->setExamDate($newDate);
    $exam->setPromo($newPromo);
    $exam->setCoef(2.5);
    $exam->setResp($newTd);

    $this->assertEquals("NewTitle", $exam->getTitle() ,"Check new Title");
    $this->assertEquals("NewDesc", $exam->getExamDesc() ,"Check new Description");
    $this->assertEquals($newDate, $exam->getExamDate() ,"Check new Date");
    $this->assertEquals($newPromo, $exam->getPromo() ,"Check new Promo");
    $this->assertEquals(2.5, $exam->getCoef(),"Check new Coef (2.5)");
    $this->assertEquals($newTd, $exam->getResp(),"Check new TD Resp");
  }

  /**
   * Test records array
   */
  public function testRecords()
  {
    $exam = $this->createExam($this->promo, $this->td, $this->date);
    $this->assertCount(0, $exam->getRecords());

    $student = $this->createStudent();
    $record = $this->createRecord(array('exam' => $exam, 'student' => $student));
    $exam->addRecord($record);

    $query = $this->em->createQuery("SELECT re FROM UnsapaIPWBundle:Record re WHERE re.exam = :exam")->setParameter("exam", $exam);
    $records = $query->getResult();
    $this->assertCount(1, $records);

    $exam = $this->em->getRepository("UnsapaIPWBundle:Exam")->find($exam->getId());
    $this->assertCount(1, $exam->getRecords());

    $student = $this->createStudent(array('username' => 'usertest2', 'email' => 'usertest2@example.com'));
    $record = new Record(array('student' => $student, 'exam' => $exam));
    $exam->addRecord($record);
    $this->assertCount(2, $exam->getRecords());
  }
}
