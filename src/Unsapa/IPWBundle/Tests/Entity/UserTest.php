<?php
/**
 * Testing the User Entity
 * @package Unsapa\IPWBundle\Tests\Entity
 */
namespace Unsapa\IPWBundle\Tests\Entity;

use Unsapa\IPWBundle\Tests\UnsapaTest;

use Unsapa\IPWBundle\Entity\Exam;
use Unsapa\IPWBundle\Entity\Promo;
use Unsapa\IPWBundle\Entity\User;
use Unsapa\IPWBundle\Entity\Record;

/**
 * Tests the entity User
 * @see Unsapa\IPWBundle\Entity\User
 */
class UserTest extends UnsapaTest
{
  /**
   * @var User user
   * User to do the tests with.
   */
  private $user;

  public function setUp()
  {
    parent::setUp();
    $this->user = $this->createStudent();
  }

  public function testToString()
  {
    $this->assertEquals("User Test", $this->user->__toString());
  }

  public function testFirstname()
  {
    $this->assertEquals("Test", $this->user->getFirstname());
    $this->user->setFirstname("Unsapa");
    $this->assertEquals("Unsapa", $this->user->getFirstname());
  }

  public function testLastname()
  {
    $this->assertEquals("User", $this->user->getLastname());
    $this->user->setLastname("IPW");
    $this->assertEquals("IPW", $this->user->getLastname());
  }

  public function testAddress()
  {
    $this->assertEquals("", $this->user->getAddress());
    $this->user->setAddress("Parc de l'innovation ISU");
    $this->assertEquals("Parc de l'innovation ISU", $this->user->getAddress());
  }

  public function testZipcode()
  {
    $this->assertEquals("", $this->user->getZipcode());
    $this->user->setZipcode("67000");
    $this->assertEquals("67000", $this->user->getZipcode());
  }

  public function testCity()
  {
    $this->assertEquals("", $this->user->getCity());
    $this->user->setCity("Illkirch");
    $this->assertEquals("Illkirch", $this->user->getCity());
  }

  public function testPhone()
  {
    $this->assertEquals("", $this->user->getPhone());
    $this->user->setPhone("0388123456");
    $this->assertEquals("0388123456", $this->user->getPhone());
  }

  public function testPromo()
  {
    $this->assertEquals(NULL, $this->user->getPromo());
    $promo = $this->createPromo();
    $this->user->setPromo($promo);
    $this->assertEquals($promo, $this->user->getPromo());
  }

  public function testCurrent()
  {
    $this->assertEquals("", $this->user->getCurrent());
  }
}
