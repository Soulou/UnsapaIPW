<?php

namespace Unsapa\IPWBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundException;

/** 
 * Manage actions where promotions are concerned
 */
class PromoController extends Controller
{
  /**
   * route : /exams/add/students
   * Get the list of students for the current Promo
   * In JSON format
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
   * route : /stats
   * Get the averages of all the Promos
   */
  public function statsAction()
  {
  	
  	
  	return $this->render('UnsapaIPWBundle:Stats:stats.html.twig',
          array());
  }
}
