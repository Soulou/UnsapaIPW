<?php
/**
 *
 * RegistrationController.php
 * @package Unsapa\IPWBundle\Controller
 */
namespace Unsapa\IPWBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Unsapa\IPWBundle\Entity\Record;

/**
 * Override FOS controller
 * Controller managing the registration
 */
class RegistrationController extends BaseController
{
    public function setDefaultExams($user)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $now = new \Datetime('now');
        $exams = $em->createQuery("SELECT e FROM UnsapaIPWBundle:Exam e WHERE e.promo = :promo AND e.exam_date >= :date")
          ->setParameters(array('date' => $now, "promo" => $user->getPromo()))
          ->getResult();

        foreach($exams as $exam)
        {
          $record = new Record();
          $record->setExam($exam);
          $record->setStudent($user);
          $em->persist($record);
        }
        $em->flush();
    }

    public function registerAction()
    {
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();

            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $this->authenticateUser($user);
                $route = 'fos_user_registration_confirmed';
            }

            $this->setDefaultExams($user);

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);

            return new RedirectResponse($url);
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
            'theme' => $this->container->getParameter('fos_user.template.theme'),
        ));
    }
}
