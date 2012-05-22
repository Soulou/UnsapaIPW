<?php
/**
 * ApplicationController.php
 *
 * @date 04/24/2012
 * @package Unsapa\IPWBundle\Controller
 */

namespace Unsapa\IPWBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Controller for the root of the website
 */
class ApplicationController extends Controller
{
    /**
     * Index of the application
     * Route: /
     */
    public function indexAction()
    {
        return $this->render('UnsapaIPWBundle:Application:index.html.twig');
    }
}
