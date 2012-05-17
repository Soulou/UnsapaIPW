<?php

namespace Unsapa\IPWBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends Controller
{
    public function indexAction()
    {
    	$users = $this->getDoctrine()->getRepository("UnsapaIPWBundle:User")->findAll();
    	 
    	if($this->get('security.context')->isGranted("ROLE_ADMIN"))
    	{
    		return $this->render('UnsapaIPWBundle:Users:index_admin.html.twig', array("users"=>$users));
    	}
    	else
    	{
    		return $this->render('UnsapaIPWBundle:Users:index_user.html.twig', array("users"=>$users));
    	}
    }
}
