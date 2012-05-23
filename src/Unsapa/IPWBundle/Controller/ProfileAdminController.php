<?php

namespace Unsapa\IPWBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Unsapa\IPWBundle\Entity\User;
use Unsapa\IPWBundle\Form\Type\ProfileFormType;

class ProfileAdminController extends Controller
{
    /**
     * Show the user
     */
    public function showIdAction($id)
    {
    	$user = $this->get('doctrine')->getRepository("UnsapaIPWBundle:User")->find($id);
      return $this->render('FOSUserBundle:Profile:show.html.twig', array('user' => $user));
    }
    
    public function editIdAction($id)
    {
    	$current_user = $this->get('security.context')->getToken()->getUser();
    	$user = $this->get('doctrine')->getRepository("UnsapaIPWBundle:User")->find($id);

    	if(!($this->get('security.context')->isGranted("ROLE_ADMIN"))
    			&& $current_user != $user)
    	{
            throw new AccessDeniedException('This user does not have access to this section.');
    	}

      $form = $this->createForm(new ProfileFormType(), $user);

      if($this->getRequest()->getMethod() == "POST")
      {
          $form->bindRequest($this->getRequest());
          if($form->isValid())
          {
              $em = $this->getDoctrine()->getEntityManager();
              var_dump($user);
              $em->persist($user);
              $em->flush();
              return $this->redirect($this->generateUrl('users_show', array('id' => $user->getId())));
          }
      }

      return $this->render('UnsapaIPWBundle:Profile:edit.html.twig', array('form' => $form->createView(), 'user' => $user));
    }
}
