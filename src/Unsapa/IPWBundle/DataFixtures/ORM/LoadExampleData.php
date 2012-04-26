<?php
/**
 * LoadExampleData.php
 *
 * @author Léo
 * @date 2012/04/26
 */

namespace Unsapa\IPWBundle\DataFixtures\ORM;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

use FOS\UseBundle\Entity\UserManager;

use Unsapa\IPWBundle\Entity\User;
use Unsapa\IPWBundle\Entity\Exam;
use Unsapa\IPWBundle\Entity\Promo;
use Unsapa\IPWBundle\Entity\Record;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
       $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $promo1 = new Promo();
        $promo2 = new Promo();
        $promo3 = new Promo();

        $promo1->setName("2011");
        $promo2->setName("2012");
        $promo3->setName("2013");

        $manager->persist($promo1);
        $manager->persist($promo2);
        $manager->persist($promo3);

        $exam1_1 = new Exam();
        $exam1_2 = new Exam();
        $exam2 = new Exam();
        $exam3 = new Exam();

        $exam1_1->setPromo($promo1);
        $exam1_2->setPromo($promo1);
        $exam2->setPromo($promo2);
        $exam3->setPromo($promo3);

        $exam1_1->setTitle("MST");
        $exam1_2->setTitle("MAN");
        $exam2->setTitle("ILO");
        $exam3->setTitle("OPT1");

        $exam1_1->setExamDesc("Maths : Statistiques");
        $exam1_2->setExamDesc("Maths : Analyse Numérique");
        $exam2->setExamDesc("Informatique : Langage Object");
        $exam3->setExamDesc("Option 1");

        $exam1_1->setExamDate(new \DateTime("2012-05-12 14:00:00"));
        $exam1_2->setExamDate(new \DateTime("2012-05-20 10:00:00"));
        $exam2->setExamDate(new \DateTime("2011-12-15 15:00:00"));
        $exam3->setExamDate(new \DateTime("2011-11-21 8:00:00"));

        $exam1_1->setCoef(1.5);
        $exam1_2->setCoef(0.5);
        $exam2->setCoef(2);
        $exam3->setCoef(1);

        $manager->persist($exam1_1);
        $manager->persist($exam1_2);
        $manager->persist($exam2);
        $manager->persist($exam3);

        $manager->flush();

        $userManager = $this->container->get('fos_user.user_manager');
        $users = array();

        for($i = 1; $i <= 10; $i++)
        {
            $newUser = $userManager->createUser();
            $newUser->setUsername("user" . $i);
            $newUser->setUsernameCanonical("user" . $i);
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($newUser);
            $password = $encoder->encodePassword('user' . $i, $newUser->getSalt());
            $newUser->setPassword($password);
            $newUser->setEmail("user" . $i . "@example.com");
            $newUser->addRole("ROLE_STUDENT");
            $newUser->setEnabled(true);
            $newUser->setFirstname("User" . $i);
            $newUser->setLastname("Test");
            $newUser->setAddress($i . " 5th Avenue");
            $newUser->setZipCode($i . $i . $i . "NY");
            $newUser->setCity("New York City");
            $manager->persist($newUser);
            array_push($users, $newUser);
        }
        $manager->flush();

        for($i = 1; $i <= 5; $i++)
        {
          $record = new Record();
          $record->setStudent($users[$i-1]);
          $record->setExam($exam1_1);
          $record->setMark(rand(2,19));
          $manager->persist($record);
        }
        for($i = 1; $i <= 5; $i++)
        {
          $record = new Record();
          $record->setStudent($users[$i-1]);
          $record->setExam($exam1_2);
          $record->setMark(rand(2,19));
          $manager->persist($record);
        }
        for($i = 1; $i <=3; $i++)
        {
          $record = new Record();
          $record->setStudent($users[$i+4]);
          $record->setExam($exam2);
          $record->setMark(rand(2,19));
          $manager->persist($record);
        }
        for($i = 1; $i <=2; $i++)
        {
          $record = new Record();
          $record->setStudent($users[$i+7]);
          $record->setExam($exam3);
          $record->setMark(rand(2,19));
          $manager->persist($record);
        }
    }
}

?>

