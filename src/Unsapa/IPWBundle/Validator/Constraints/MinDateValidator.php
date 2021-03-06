<?php
/**
 * MinDateValidator.php
 *
 * @author leo@soulou.fr
 * @date 05/16/2012
 * @package Unsapa\IPWBundle\Validator\Constraints
 */

namespace Unsapa\IPWBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Validate the MinDate Constraint
 */
class MinDateValidator extends ConstraintValidator
{
    /**
     * Check if a date is valid.
     *
     * @param $value input of the user
     * @param Constraint $constraint Constraint definition from MinDate Class
     */
    public function validate($value, Constraint $constraint)
    {
        if($value == null || $value == '')
            return;
        
        $now = new \DateTime($constraint->limit);
        if(!$now)
            throw new UnexpectedTypeException($value, 'date (validator limit)');

        if($value < $now)
        {
            $this->context->addViolation($constraint->message, array(
                '{{ value }}' => $value,
                '{{ limit }}' => $constraint->limit,
            ));
        }
    }
}
