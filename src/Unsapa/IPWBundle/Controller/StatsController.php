<?php
/**
 * This file defines the controller to manage the statistics
 * @package Unsapa\IPWBundle\Controller
 */

namespace Unsapa\IPWBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Unsapa\IPWBundle\Entity\Record;
use Unsapa\IPWBundle\Entity\Promo;
use Unsapa\IPWBundle\Entity\Exam;


/**
 * Define actions of the statistics
 */
class StatsController extends Controller
{    
	/**
     * Get the averages of all the Promos
     * Route : /stats
     */
    public function averagesAction()
    {
        $promos = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Promo")->findAll();
        $exams_ended = $this->getDoctrine()->getEntityManager()->createQuery(
            "SELECT e FROM UnsapaIPWBundle:Exam e WHERE e.exam_date < :date")
            ->setParameter("date", (new \Datetime('now')))
            ->getResult();

        $stats_by_promo = array();
        foreach($promos as $promo)
        {
            $pname = $promo->getName();
            $stats_by_promo[$pname] = array();
            $stats_by_promo[$pname]['promo'] = $promo;
            $stats_by_promo[$pname]['exams_data'] = array();
        }
            

 
        foreach($exams_ended as $exam)
        {
            $exam_data = array('exam' => $exam);

        	$records = $exam->getRecords();
        	$tmp_sum = 0;
        	$tmp_nb_marks = 0;
        	foreach($records as $record)
        	{
        		if (($mark=$record->getMark()) != NULL)
        		{
        			$tmp_nb_marks += 1;
        			$tmp_sum += $mark;
        		}
            }

            $exam_data['nb_records'] = $tmp_nb_marks;
        	
        	if ($tmp_nb_marks != 0)
        	{
        		$average = $tmp_sum/$tmp_nb_marks;
        	}
        	else $average = NULL;

            $exam_data['average'] = $average;
            array_push($stats_by_promo[$exam->getPromo()->getName()]['exams_data'], $exam_data);
        }


    	return $this->render('UnsapaIPWBundle:Stats:stats.html.twig',
    			array('stats_by_promo' => $stats_by_promo));
    }
}
