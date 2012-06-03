<?php
/**
 * Testing the Record Entity
 * @package Unsapa\IPWBundle\Tests\Entity
 */
namespace Unsapa\IPWBundle\Tests\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use Unsapa\IPWBundle\Tests\UnsapaTest;

use Unsapa\IPWBundle\Entity\Exam;
use Unsapa\IPWBundle\Entity\Promo;
use Unsapa\IPWBundle\Entity\User;
use Unsapa\IPWBundle\Entity\Record;

/**
 * Tests the entity Recprd
 * @see Unsapa\IPWBundle\Entity\Record
 */
class RecordTest extends UnsapaTest
{
  /**
   * @var Record $record for generic tests
   */
  private $record;
  /**
   * @var User student 
   */
  private $student;
  /**
   * @var Exam $exam
   */
  private $exam;
  /**
   * @var Promo $promo
   */
  private $promo;
  /**
   * @var User $td
   */
  private $td;

  /**
   * Setup
   */
  public function setUp()
  {
    parent::setUp();
    $this->td = $this->createRespTD();
    $this->promo = $this->createPromo();
    $this->exam = $this->createExam($this->promo, $this->td);
    $this->student = $this->createStudent();
    $this->record = $this->createRecord(array(
      'student' => $this->student,
      'exam' => $this->exam
    ));
  }

  /**
   * Test that we can't save a record without Student
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage This value should not be null.
   */
  public function testEmptyStudent()
  {
    $record = $this->createRecord(array(
      'exam' => $this->exam
    ));
  }

  /**
   * Test that we can't save a record with an empty Exam
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage This value should not be null.
   */
  public function testEmptyNamePromo()
  {
    $record = $this->createRecord(array(
      'student' => $this->student,
    ));
  }

  /**
   * Test Record toString
   */
  public function testToString()
  {
    $this->assertEquals('{"exam":'.$this->exam->getId().
      ',"student":'.$this->student->getId().',"mark":null,"document":false}', 
      $this->record->__toString());
  }

  /**
   * Test Getter and Setter
   */
  public function testName()
  {
    $this->assertEquals($this->student, $this->record->getStudent());
    $this->assertEquals($this->exam, $this->record->getExam());
    $this->assertEquals(NULL, $this->record->getDocument());
    $this->assertEquals(NULL, $this->record->getMark());

    $exam = $this->createExam($this->promo, $this->td, NULL, "Test2");
    $this->record->setExam($exam);
    $this->assertEquals($exam, $this->record->getExam());

    $st = $this->createStudent(array('username'=>"Username2", 'email'=>'email@coucou.com'));
    $this->record->setStudent($st);
    $this->assertEquals($st, $this->record->getStudent());

    $this->record->setMark(10);
    $this->assertEquals(10, $this->record->getMark());

    $this->record->setDocument("./a.pdf");
    $this->assertEquals("./a.pdf", $this->record->getDocument());
  }

  /**
   * Test two Record with the same couple student/exam
   * @expectedException PDOException
   */
  public function testDoubleRecord()
  {
    $record = $this->createRecord(array(
      'student' => $this->student,
      'exam' => $this->exam
    ));
    $record = $this->createRecord(array(
      'student' => $this->student,
      'exam' => $this->exam
    ));
  }

  /**
   * Test file attribute manipulation
   */
  public function testFileAttr()
  {
    $this->record->setDocument(NULL);
    $this->assertEquals(NULL, $this->record->getDocument());

    $this->record->preUpload();
    $this->assertEquals(NULL, $this->record->getDocument());

    $file = new UploadedFile(__DIR__."/../../../../../data/sampleDocument.pdf", "sampleDocument.pdf");
    $this->record->setFile($file);
    $this->assertEquals($file, $this->record->getFile());

    $this->record->preUpload();
    $this->assertRegExp("/[a-z0-9]{40}\.pdf/", $this->record->getDocument());

    $sha = $this->record->getDocument();

    $this->assertEquals("uploads/records/$sha", $this->record->getDocumentWebPath());
    $this->assertRegExp("+.*/web/uploads/records/$sha+", $this->record->getDocumentAbsolutePath());
    $this->assertEquals("$sha", $this->record->getDocumentName());

    
  }

  /** 
   * Test the upload function
   * @expectedException Symfony\Component\HttpFoundation\File\Exception\FileException
   */
  public function testUpload()
  {
    $file = new UploadedFile(__DIR__."/../../../../../data/sampleDocument.pdf", "sampleDocument.pdf");
    $this->record->setFile($file);
    $this->record->upload();
  }

  /**
   * Test the upload function  when there is no document
   */
  public function testEmptyUpload()
  {
    $this->record->setFile(NULL);

    $this->assertEquals(NULL, $this->record->getDocumentName());
    $this->record->upload();
  }

  /**
   * Test when a record is deleted
   */
  public function testRemoveUpload()
  {
    $file = new UploadedFile(__DIR__."/../../../../../data/sampleDocument.pdf", "sampleDocument.pdf");
    $this->record->setFile($file);

    $this->record->removeUpload();
  }
}
