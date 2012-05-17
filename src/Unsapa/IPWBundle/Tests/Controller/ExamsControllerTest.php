<?php
/**
 * Testing the ExamController
 * @package Unsapa\IPWBundle\Tests\Controller
 */

namespace Unsapa\IPWBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

use Application\FaxServerBundle\DataFixtures\ORM\NetworkConfigurationData;

/**
 * Class to test the ExamsController
 * @see Unsapa\IPWBundle\Controller\ExamsController
 */
class ExamsControllerTest extends WebTestCase
{
  /**
   * Set up test env
   */
  public function setUp()
  {
    parent::setUp();
  }

  public function testPass()
  {
    $this->assertTrue(TRUE);
  }

  /**
   * Tear down test env
   */
  public function tearDown()
  {
    parent::tearDown();
  }
}
