<?php
/**
 * This file handle the creation of the add/edit promo form
 * @package Unsapa\IPWBundle\Form
 */

namespace Unsapa\IPWBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Class to manage the promo Add and Edit HTML form
 */
class PromoForm extends AbstractType
{
    /**
     * Override function from AbstractType
     * Add name field to the form
     * @param FormBuilder $builder FormBuilder to create the form
     * @param array $options Options to create the form
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => "Promotion : "));
    }

    /**
     * Return the name of the form
     * @return String
     */
    public function getName()
    {
    	return 'PromoForm';
    }
}
