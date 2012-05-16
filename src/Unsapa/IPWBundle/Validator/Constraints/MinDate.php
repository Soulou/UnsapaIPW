<?php

namespace Unsapa\IPWBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @annotation
 * Validation of date, ask for a minimal date
 */
class MinDate extends Constraint 
{
    public $message = "This date is too late";
    public $limit;

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
       return 'limit';
    }

    /**
    * * {@inheritDoc}
    * */
    public function getRequiredOptions()
    {
        return array('limit');
    }
}
