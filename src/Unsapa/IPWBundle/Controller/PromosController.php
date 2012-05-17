<?php
/**
 * This file defines the controller to manage promotions
 * @package Unsapa\IPWBundle\Controller
 */

namespace Unsapa\IPWBundle\Controller;

use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Unsapa\IPWBundle\Entity\Record;
use Unsapa\IPWBundle\Entity\Promo;
use Unsapa\IPWBundle\Form\PromoForm;

/**
 * Manage actions where promotions are concerned
 */
class PromosController extends Controller
{
    /**
     * Show all the promotions
     * Route : /promos
     */
    public function indexAction()
    {
    	$promos = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Promo")->findAll();
    	
    	if($this->get('security.context')->isGranted("ROLE_ADMIN"))
    	{
    		return $this->render('UnsapaIPWBundle:Promos:index_admin.html.twig', array("promos"=>$promos));
    	}
    	else
    	{
    		return $this->render('UnsapaIPWBundle:Promos:index_user.html.twig', array("promos"=>$promos));
    	}
    }

    /**
     * Add a new promotion
     * Route : /promos/add
     */
    public function addAction()
    {
    	$promo = new Promo();
    	$form = $this->createForm(new PromoForm(), $promo);
    	
    	if($request->getMethod() == "POST")
    	{
    		$form->bindRequest($this->getRequest());
    	
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

    /**
     * Edit the promotion name
     * Route /promos/{id}/edit
     * @param integer $id Identifier of the promo
     */
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
    
    /**
     * Get the list of students for the current Promo
     * In JSON format
     * Route : /exams/add/students
     */
    public function listStudentsAction()
    {
    	$r = $this->getRequest()->request;
    
    	if(!$r->has('promo'))
    		throw $this->createNotFoundException("Cette promo n'existe pas");
    
    	$promo = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Promo")->find($r->get('promo'));
    	$users = $this->getDoctrine()->getRepository("UnsapaIPWBundle:User")->findByPromo($promo);
    
    	$users_return = array();
    	foreach($users as $user)
    	{
    		$user_a = array("id" => $user->getId(), "firstname" => $user->getFirstName(), "lastname" => $user->getLastName());
    		array_push($users_return, $user_a);
    	}
    
    	return new Response(json_encode($users_return));
    }
   
    /**
     * Get the averages of all the Promos
     * Route : /stats
     */
    public function statsAction()
    {
    	return $this->render('UnsapaIPWBundle:Stats:stats.html.twig',
    			array());
    }
}
