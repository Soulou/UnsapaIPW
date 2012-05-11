<?php

namespace Unsapa\IPWBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

use Application\FaxServerBundle\DataFixtures\ORM\NetworkConfigurationData;

class ExamsControllerTest extends WebTestCase
{
  public function setUp()
  {
    parent::setUp();
  }

  public function testPass()
  {
    $this->assertTrue(TRUE);
  }

  public function tearDown()
  {
    parent::tearDown();
  }
}
