<?php

namespace Unsapa\IPWBundle\Controller;

use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Unsapa\IPWBundle\Entity\Record;
use Unsapa\IPWBundle\Entity\Promo;
use Unsapa\IPWBundle\Form\PromoForm;

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
    	$form = $this->createForm(new PromoForm(), $promo);
    	
    	if($request->getMethod() == "POST")
    	{
    		$form->bindRequest($request);
    	
    		if($form->isValid())
    		{
    			$manager = $this->get('doctrine')->getEntityManager();
    			$manager->persist($promo);
    			$manager->flush();
    			
    			return $this->redirect($this->generateUrl('promos'));
    		}
    	}
    	return $this->render('UnsapaIPWBundle:Promos:add.html.twig', array(
    			'promo' => $promo,
    			'form' => $form->createView()
    			));
    	
    }
    
    public function editAction($id)
    {
    	$promo = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Promo")->find($id);
    	$form = $this->createForm(new PromoForm(), $promo);
    		
    	$request = $this->getRequest();
    	if($request->getMethod() == "POST")
    	{
    		$form->bindRequest($request);
    		 
    		if($form->isValid())
    		{
    			echo $promo->getId();
    			$manager = $this->get('doctrine')->getEntityManager();
    			$manager->persist($promo);
    			$manager->flush();
    			 
    			return $this->redirect($this->generateUrl('promos'));
    		}
    	}
    	return $this->render('UnsapaIPWBundle:Promos:edit.html.twig', array(
    			'promo' => $promo,
    			'form' => $form->createView()
    			));
    	 
    }
}
