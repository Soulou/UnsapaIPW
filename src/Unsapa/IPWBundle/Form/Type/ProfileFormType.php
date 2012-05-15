<?php

namespace Unsapa\IPWBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildUserForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('lastname', 'text', array('required'=>true))
            ->add('firstname', 'text', array('required'=>true))
            ->add('address')
            ->add('zipcode')
            ->add('city')
            ->add('phone')
        ;
    }

    public function getName()
    {
        return 'user_profile';
    }
}
