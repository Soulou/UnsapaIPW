<?php
/**
 * MinDate.php
 *
 * @author leo@soulou.fr
 * @date 05/16/2012
 * @package Unsapa\IPWBundle\Validator\Constraints
 */

namespace Unsapa\IPWBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Validation of date, ask for a minimal date
 * @annotation
 */
class MinDate extends Constraint 
{
    /**
     * Message if the value is invalid
     */
    public $message = "This date is too late";
    /**
     * Before this limit date, the date is invalid
     */
    public $limit;

    /**
     * Get the Default Option
     */
    public function getDefaultOption()
    {
       return 'limit';
    }

    /**
     * Get the requires options
     */
    public function getRequiredOptions()
    {
        return array('limit');
    }
}
