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
class ProfileAdminFormType extends AbstractType
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
            ->add('roles', 'choice', array('multiple' => true,
              'choices' => array('ROLE_STUDENT' => 'ROLE_STUDENT',
                                 'ROLE_TD' => 'ROLE_TD',
                                 'ROLE_ADMIN' => 'ROLE_ADMIN')))
            ->add('enabled', 'checkbox', array('required'=>false))
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
