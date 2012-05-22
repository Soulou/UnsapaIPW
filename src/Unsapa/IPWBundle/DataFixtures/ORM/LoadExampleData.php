<?php
/**
 * LoadExampleData.php
 *
 * @author leo@soulou.fr
 * @date 2012/04/26
 * @package Unsapa\IPWBundle\DataFixtures\ORM
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

define("LOREMIPSUM", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur lobortis tellus vitae dolor pellentesque laoreet. Morbi nec accumsan velit. Sed felis felis, vulputate at blandit non, ultrices ut lorem. Nullam eu nunc massa, vel imperdiet tortor. Pellentesque hendrerit cursus diam et dictum. Donec vehicula, lacus at mollis adipiscing, risus ligula dignissim mi, id fermentum augue tortor nec magna. Duis venenatis, ante non interdum cursus, neque augue viverra neque, non luctus urna libero vel risus. Duis eros augue, pellentesque ac lacinia eget, tempus in libero.");


/**
 * Define some fixtures to test the application
 */
class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * Entity manager for persistance
     */
    private $em;

    /**
     * User manager for user persistance
     */
    private $um;

    /**
     * Container for the ContainerAwareInterface
     */
    private $container;

    /**
     * Set default container
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
       $this->container = $container;
    }

    /**
     * Create file TestExam.pdf
     */
    public function createSampleFile()
    {
        $file = sha1("TestExam") . ".pdf";
        copy("data/sampleDocument.pdf", "web/uploads/records/" . $file);
    }

    /**
     *  Create promo and save it
     *  @param string $name name of the promotion
     *  @return Promo The newly created promotion
     */
    public function createPromo($name = "")
    {
        $p = new Promo($name);
        $this->em->persist($p);
        $this->em->flush();
        return $p;
    }

    /**
     * Create user and save it
     * @param array $values Values of the attributes of the entity
     * @return User The newly created Student
     */
    public function createUser(array $values = array())
    {
        $u = $this->um->createUser();
        if(isset($values['password']))
        {
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($u);
            $values['password'] = $encoder->encodePassword($values['password'], $u->getSalt());
        }
        $u->initUser($values);
        $this->em->persist($u);
        $this->em->flush();
        return $u;
    }

    /**
     * Create a td manager and save it
     * @param array $values Values of the attributes of the entity
     * @return User The newly created TD manager
     */
    public function createTD(array $values = array())
    {
        $td = $this->createUser($values);
        $td->addRole("ROLE_TD");
        $this->em->persist($td);
        $this->em->flush();
        return $td;
    }

    /**
     * Create an exam and save it to the database
     * @param array $values Values of the attributes of the entity
     * @return Exam The newly created exam
     */
    public function createExam(array $values = array())
    {
        $exam = new Exam($values);
        $this->em->persist($exam);
        $this->em->flush();
        return $exam;
    }

    /**
     * Create a record and save it to the database
     * @param array $values Values of the attributes of the entity
     * @return Record The newly created record
     */
    public function createRecord(array $values = array())
    {
        $record = new Record($values);
        $this->em->persist($record);
        $this->em->flush();
        return $record;
    }

    /**
     * Function called to load the data to the database
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->createSampleFile();

        $this->em = $manager;
        $this->um = $this->container->get('fos_user.user_manager');

        $promo1 = $this->createPromo("2012");
        $promo2 = $this->createPromo("2013");
        $promo3 = $this->createPromo("2014");
        $promos = array($promo1, $promo2, $promo3);
        $users = array();


        for($i = 1; $i <= 10; $i++)
        {
            for($j = 0; $j < count($promos) ; $j++)
            {
                $newUser = $this->createUser(array(
                  'username' => "user" . $promos[$j]->getName() . $i,
                  'password' => "user" . $promos[$j]->getName() . $i,
                  'email' => "user" . $promos[$j]->getName() . $i . "@example.com",
                  'firstname' => "User" . $promos[$j]->getName() . $i,
                  'lastname' => "Test",
                  'address' => $i . " 5th Avecnue",
                  'zipcode' => $i . $i . $i . "NY",
                  'city' => "New York City",
                  'promo' => $promos[$j]
                ));

                array_push($users, $newUser);
            }
        }

        $tds = array();
        for($i = 1; $i <= 5; $i++)
        {
            $newUser = $this->createTD(array(
              'username' => "tduser" . $i,
              'password' => "tduser" . $i,
              'email' => "tduser" . $i . "@example.com",
              'firstname' => "TDuser" . $i,
              'lastname' => "Test",
              'address' => $i . " 5th Avecnue",
              'zipcode' => $i . $i . $i . "NY",
              'city' => "New York City",
            ));

            array_push($tds, $newUser);
        }

        $admin = $this->createUser(array(
            'username' => "admin",
            'password' => "admin",
            'email' => "admin" . "@example.com",
            'firstname' => "admin",
            'lastname' => "Test",
            'address' =>"admin 5th Avenue",
            'zipcode' => "000000NY",
            'city' => "New York City",
        ));
        $admin->addRole("ROLE_ADMIN");
        $this->em->persist($admin);
        $this->em->flush();

        $coefs = array(0.5,1,1.5,2);

        for($i = 0; $i < count($promos) ; $i++)
        {
            for($k = 0; $k < count($tds) ; $k++)
            {
                for($j = 0; $j < 6 ; $j++)
                {
                    $int = $j+$k+1 . "D";
                    $int = "P" . $int;
                    $tmp_date = new \DateTime('now');
                    if($j < 3)
                      $date = $tmp_date->sub(new \DateInterval($int));
                    if($j > 3)
                      $date = $tmp_date->add(new \DateInterval($int));

                    $exam = $this->createExam(array(
                      'title' => "Exam_" . $promos[$i] . "_" . $tds[$k]->getUsername() . "_$j",
                      'promo' => $promos[$i],
                      'exam_date' => $date,
                      'exam_desc' => LOREMIPSUM,
                      'resp' => $tds[$k],
                      'coef' => $coefs[rand(0,3)]
                    ));

                    $users_promo = $this->container->get('doctrine')->getRepository("UnsapaIPWBundle:User")->findByPromo($promos[$i]);
                    foreach($users_promo as $user)
                    {
                        if(rand(0,1) == 1)
                            // The user has given something
                            $document = sha1("TestExam") . ".pdf";
                        else
                            // The user does not have give something back
                            $document = NULL;

                        // If the exam deadline is over
                        if($date < new \DateTime('now'))
                        {
                            if(rand(0,1) == 0)
                                // Exam waiting for correction
                                $mark = NULL;
                            else 
                                // Correced exam by the td responsable
                                $mark = rand(2,19);
                        }
                        // If the exam is still pending
                        else
                        {
                            $mark = NULL;
                        }

                        $record = $this->createRecord(array(
                          'student' => $user,
                          'exam' => $exam,
                          'document' => $document,
                          'mark' => $mark
                        ));
                    }
                }
            }
        }
    }
}

?>

