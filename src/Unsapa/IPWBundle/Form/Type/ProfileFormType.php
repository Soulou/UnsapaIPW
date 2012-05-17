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
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

/**
 * Override the ProfileFormType of the FOSUserBundle to add fields to the form
 */
class ProfileFormType extends BaseType
{
    /**
     * Build user profile form
     * @param FormBuilder $builder
     * @param array $options
     */
    public function buildUserForm(FormBuilder $builder, array $options)
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
