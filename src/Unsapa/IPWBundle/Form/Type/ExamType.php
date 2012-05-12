<?php

namespace Unsapa\IPWBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ExamType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
        ->add('title', 'text', array('label' => "Titre : "))
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
        ->add('exam_date', 'date', array('widget'=>'single_text', 'label' => "Échéance : "))
        ->add('coef', 'number', array('label' => "Coefficient : "))
        ->add('exam_desc','textarea', array('label' => "Description : ", 'required' => false));
    }

    public function getName()
    {
        return 'exam';
    }
}
