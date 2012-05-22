<?php
/**
 * Definition of the Bundle
 * @package Unsapa\IPWBundle
 */

namespace Unsapa\IPWBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * { @inheritdoc }
 */
class UnsapaIPWBundle extends Bundle
{
  /**
   * Set this bundle as a child of FOSUserBundle
   */
  public function getParent()
  {
    return "FOSUserBundle";
  }
}
