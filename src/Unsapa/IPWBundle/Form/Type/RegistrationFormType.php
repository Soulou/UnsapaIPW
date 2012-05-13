<?php

namespace Unsapa\IPWBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extEnds BaseType
{
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

    public function getName()
    {
        return 'user_registration';
    }
}
