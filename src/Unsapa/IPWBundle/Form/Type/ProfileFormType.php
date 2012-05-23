<?php
/**
 * Manage Profile edition
 * @package Unsapa\IPWBundle\Form\Type
 */

namespace Unsapa\IPWBundle\Form\Type;


use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;

/**
 * Override the ProfileFormType of the FOSUserBundle to add fields to the form
 */
class ProfileFormType extends AbstractType
{
    /**
     * Build user profile form
     * @param FormBuilder $builder
     * @param array $options
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('lastname', 'text', array('required'=>true))
            ->add('firstname', 'text', array('required'=>true))
        	  ->add('promo')
            ->add('address')
            ->add('zipcode')
            ->add('city')
            ->add('phone')
        ;
    }

    /**
     * Get form name
     */
    public function getName()
    {
        return 'user_profile';
    }
}
