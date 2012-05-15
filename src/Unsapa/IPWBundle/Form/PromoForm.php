<?php

namespace Unsapa\IPWBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PromoForm extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => "Promotion : "));
    }
    
    public function getName()
    {
    	return 'PromoForm';
    }
}
