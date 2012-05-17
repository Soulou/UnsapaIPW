<?php
/**
 * Manage registration form for new users
 * @package Unsapa\IPWBundle\Form\Type
 */

namespace Unsapa\IPWBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

/**
 * Class override from the FOSUserBundle to add fields to the registration form
 */
class RegistrationFormType extEnds BaseType
{
    /**
     * Build registration form 
     * @param FormBuilder $builder
     * @param array $options
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
          ->add('firstname', 'text', array('required' => TRUE))
          ->add('lastname', 'text', array('required' => TRUE))
          ->add('promo', 'entity', array(
              'label' => "Promotion : ", 
              'class' => "UnsapaIPWBundle:Promo",
              'property' => "name",
              'query_builder' => 
                function(EntityRepository $er) {
                  return $er->createQueryBuilder('p')->orderBy('p.name', 'ASC');
                }
              )
            )
          ->add('address')
          ->add('zipcode')
          ->add('city')
          ->add('phone');
    }

    /**
     * Get form name
     */
    public function getName()
    {
        return 'user_registration';
    }
}
