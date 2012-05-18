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
    	$exams = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Exam")->findAll();
    	$exams_ended = array();
    	$nb_records = array();
    	$exams_averages = array();
    	$now = new \DateTime('now');
    	
    	foreach($exams as $exam)
        {
          if($exam->getExamDate() < $now)
            array_push($exams_ended, $exam);
        }
        
        foreach($exams_ended as $exam)
        {
        	$records = $exam->getRecords();
        	array_push($nb_records, count($records));
        	
        	$tmp_sum = 0;
        	$tmp_nb_marks = 0;
        	foreach($records as $record)
        	{
        		if (($record->getMark()) != NULL)
        		{
        			$tmp_nb_marks += 1;
        			$tmp_sum += $record->getMark();
        		}
        	}
        	
        	if ($tmp_nb_marks != 0)
        	{
        		$average = $tmp_sum/$tmp_nb_marks;
        	}
        	else $average = NULL;
        	
        	array_push($exams_averages, $average);
        }
    	
    	return $this->render('UnsapaIPWBundle:Stats:stats.html.twig',
    			array('promos'=>$promos, 'exams_ended'=>$exams_ended, 'nb_records'=>$nb_records, $exams_averages=>'exams_averages'));
    }
}