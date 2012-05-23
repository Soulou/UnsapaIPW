<?php
/**
 * Testing the Promo Entity
 * @package Unsapa\IPWBundle\Tests\Entity
 */
namespace Unsapa\IPWBundle\Tests\Entity;

use Unsapa\IPWBundle\Tests\UnsapaTest;

use Unsapa\IPWBundle\Entity\Exam;
use Unsapa\IPWBundle\Entity\Promo;
use Unsapa\IPWBundle\Entity\User;
use Unsapa\IPWBundle\Entity\Record;

/**
 * Tests the entity Promo
 * @see Unsapa\IPWBundle\Entity\Promo
 */
class PromoTest extends UnsapaTest
{
  /**
   * Test that we can't save an empty promotion
   * @ExpectedException ORMException
   * @ExpectedExceptionMessage You can't save an empty promotion
   */
  public function testEmptyPromo()
  {
    $p = new Promo();
    $this->em->persist($p);
    $this->em->flush();
  }

  /**
   * Test that we can't save a promo with an empty title
   * @ExpectedException ErrorException
   * @ExpectedExceptionMessage Name of the promotion is empty
   * WAITING FOR ANSWER : https://github.com/symfony/symfony/issues/4352
   */
  /* public function testEmptyNamePromo() */
  /* { */
    /* $p = $this->createPromo(""); */
    /* $promos = $this->em->getRepository("UnsapaIPWBundle:Promo")->findAll(); */
  /* } */

  /**
   * Test Promo toString
   */
  public function testToString()
  {
    $p = $this->createPromo("NewPromo");
    $this->assertEquals("NewPromo", $p->__toString());
  }

  /**
   * Test Getter and Setter
   */
  public function testName()
  {
    $p = $this->createPromo("NewPromo");
    $this->assertEquals("NewPromo", $p->getName());
    $p->setName("NewNewPromo");
    $this->assertEquals("NewNewPromo", $p->getName());
  }

  /**
   * Test two promotion with the same name
   * @expectedException PDOException
   */
  public function testDoubleName()
  {
    $this->createPromo("Double");
    $this->createPromo("Double");
  }

  /**
   * Test getId
   */
  public function testGetId()
  {
    $p = $this->createPromo("TestId");
    $this->assertTrue(is_integer($p->getId()));
  }
}
