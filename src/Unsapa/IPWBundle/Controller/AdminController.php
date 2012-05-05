<?php

namespace Unsapa\IPWBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Unsapa\IPWBundle\Entity\Record;
use Unsapa\IPWBundle\Entity\Promo;

class AdminController extends Controller
{
    public function indexAction()
    {
    	$promos = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Promo")->findAll();
    	return $this->render('UnsapaIPWBundle:Admin:index.html.twig', array("promos"=>$promos));
    }
    
    public function addAction(Request $request)
    {
    	$promo = new Promo();
    	$form = $this->createFormBuilder($promo)
    	->add('name', 'text', array('label' => "Promotion : "))
    	->getForm();
    	
    	if($request->getMethod() == "POST")
    	{
    		$form->bindRequest($request);
    	
    		if($form->isValid())
    		{
    			$manager = $this->get('doctrine')->getEntityManager();
    			$manager->persist($promo);
    			$manager->flush();
    			
    			return $this->redirect($this->generateUrl('admin'), 201);
    		}
    	}
    	return $this->render('UnsapaIPWBundle:Admin:add.html.twig', array('promo' => $promo, 'form' => $form->createView()));
    	
    }
}
