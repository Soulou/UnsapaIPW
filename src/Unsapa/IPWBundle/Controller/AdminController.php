<?php
/**
 * AdminController.php
 *
 * @author guparan@gmail.com
 * @date 05/14/2012
 * @package Unsapa\IPWBundle\Controller
 */
namespace Unsapa\IPWBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Unsapa\IPWBundle\Entity\Record;
use Unsapa\IPWBundle\Entity\Promo;

/**
 * Manage the administration part of the website
 */
class AdminController extends Controller
{
    /**
     * Show the administration panel
     * Route: /admin
     */
    public function indexAction()
    {
    	return $this->render('UnsapaIPWBundle:Admin:index.html.twig');
    }
}
