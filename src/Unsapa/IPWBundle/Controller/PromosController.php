<?php

namespace Unsapa\IPWBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Unsapa\IPWBundle\Entity\Record;
use Unsapa\IPWBundle\Entity\Promo;

class PromosController extends Controller
{
    public function indexAction()
    {
    	$promos = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Promo")->findAll();
    	return $this->render('UnsapaIPWBundle:Promos:index.html.twig', array("promos"=>$promos));
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
    			
    			return $this->redirect($this->generateUrl('promos'), 201);
    		}
    	}
    	return $this->render('UnsapaIPWBundle:Promos:add.html.twig', array('promo' => $promo, 'form' => $form->createView()));
    	
    }
}
