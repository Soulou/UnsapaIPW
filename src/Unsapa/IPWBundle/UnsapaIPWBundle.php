<?php

namespace Unsapa\IPWBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UnsapaIPWBundle extends Bundle
{
  public function getParent()
  {
    return "FOSUserBundle";
  }
}
