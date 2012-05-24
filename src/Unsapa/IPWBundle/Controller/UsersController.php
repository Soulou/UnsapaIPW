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
    	 
    	return $this->render('UnsapaIPWBundle:Users:index.html.twig', array("users"=>$users));
    }
}
