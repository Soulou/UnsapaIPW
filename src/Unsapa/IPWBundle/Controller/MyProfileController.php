<?php

namespace Unsapa\IPWBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Unsapa\IPWBundle\Entity\User;

class MyProfileController extends Controller
{
    /**
     * Show the user
     */
    public function showIdAction($id)
    {
    	$user = $this->getDoctrine()->getRepository("UnsapaIPWBundle:User")->find($id);
    	
        return $this->container->get('templating')->renderResponse('FOSUserBundle:Profile:show.html.'.$this->container->getParameter('fos_user.template.engine'), array('user' => $user));
    }
    
    public function editIdAction($id)
    {
    	$current_user = $this->get('security.context')->getToken()->getUser();
    	$user = $this->getDoctrine()->getRepository("UnsapaIPWBundle:User")->find($id);

    	if(!($this->get('security.context')->isGranted("ROLE_ADMIN"))
    			&& $current_user != $user)
    	{
            throw new AccessDeniedException('This user does not have access to this section.');
    	}
    	
    	$form = $this->container->get('fos_user.profile.form');
    	$formHandler = $this->container->get('fos_user.profile.form.handler');
    	
    	$process = $formHandler->process($user);
    	if ($process) {
    		$this->setFlash('fos_user_success', 'profile.flash.updated');
    	
    		return new RedirectResponse($this->container->get('router')->generate('fos_user_profile_show'));
    	}
    	
    	return $this->container->get('templating')->renderResponse(
    			'FOSUserBundle:Profile:edit.html.'.$this->container->getParameter('fos_user.template.engine'),
    			array('form' => $form->createView(), 'theme' => $this->container->getParameter('fos_user.template.theme'))
    	);
    }
}
