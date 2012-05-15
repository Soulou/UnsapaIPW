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
    	return $this->render('UnsapaIPWBundle:Admin:index.html.twig');
    }
}
