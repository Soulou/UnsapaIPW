<?php

namespace Unsapa\IPWBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extEnds BaseType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('firstname');
        $builder->add('lastname');
    }

    public function getName()
    {
        return 'user_registration';
    }
}
