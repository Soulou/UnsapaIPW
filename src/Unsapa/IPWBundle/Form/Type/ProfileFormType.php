<?php

namespace Unsapa\IPWBundle\Form\Type;


use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
        	->add('promo')
            ->add('address')
            ->add('zipcode')
            ->add('city')
            ->add('phone')
        ;
    }
    /*
    public function getDefaultOptions($options)
    {
    	return array(
    			'data_class' => $this->class,
    			'intention'  => 'profile',
    	);
    }
	*/
    public function getName()
    {
        return 'user_profile';
    }
}
