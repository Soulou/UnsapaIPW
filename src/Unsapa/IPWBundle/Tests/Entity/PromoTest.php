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
   * @var Promo $promo for generic tests
   */
  private $promo;

  /**
   * Setup
   */
  public function setUp()
  {
    parent::setUp();
    $this->promo = $this->createPromo("TestPromo");
  }

  /**
   * Test that we can't save an empty promotion
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage This value should not be blank.
   */
  public function testEmptyPromo()
  {
    $p = new Promo();
    $this->validate($p);
    $this->em->persist($p);
    $this->em->flush();
  }

  /**
   * Test that we can't save a promo with an empty title
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage This value should not be blank.
   */
  public function testEmptyNamePromo()
  {
    $p = $this->createPromo("");
  }

  /**
   * Test Promo toString
   */
  public function testToString()
  {
    $this->assertEquals("TestPromo", $this->promo->__toString());
  }

  /**
   * Test Getter and Setter
   */
  public function testName()
  {
    $this->assertEquals("TestPromo", $this->promo->getName());
    $this->promo->setName("NewPromo");
    $this->assertEquals("NewPromo", $this->promo->getName());
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
