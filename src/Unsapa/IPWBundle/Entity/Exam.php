<?php
/**
 * Exam.php
 *
 * @date 04/24/2012
 * @package Unsapa\IPWBundle\Entity
 */

namespace Unsapa\IPWBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Unsapa\IPWBundle\Entity\Exam
 */
class Exam
{
    /**
     * Identifier of the exam
     * @var integer $id
     */
    private $id;

    /**
     * Title of the exam
     * @var string $title
     */
    private $title;

    /**
     * Td manager, responsible of the exam
     * @var Unsapa\IPWBundle\Entity\User
     */
    private $resp;

    /**
     * Description of the exam
     * @var text $exam_desc
     */
    private $exam_desc;

    /**
     * End date of the exam
     * @var datetime $exam_date
     */
    private $exam_date;

    /**
     * Coefficient of the exam
     * @var float $coef
     */
    private $coef;

    /**
     * Promotion concerned by the exam
     * @var Unsapa\IPWBundle\Entity\Promo
     */
    private $promo;

    /**
     * All the records which concerned this exam
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $records;

    /**
     * Main constructor
     * Initialize the records array
     * @param array $values Values of the attributes
     */
    public function __construct(array $values = array())
    {
        if(isset($values['title']))
          $this->title = $values['title'];
        if(isset($values['promo']))
          $this->promo = $values['promo'];
        if(isset($values['exam_date']))
          $this->exam_date = $values['exam_date'];
        if(isset($values['exam_desc']))
          $this->exam_desc = $values['exam_desc'];
        if(isset($values['coef']))
          $this->coef = $values['coef'];
        if(isset($values['resp']))
          $this->resp = $values['resp'];
        $this->records = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Exam
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set exam_desc
     *
     * @param text $examDesc
     * @return Exam
     */
    public function setExamDesc($examDesc)
    {
        $this->exam_desc = $examDesc;
        return $this;
    }

    /**
     * Get exam_desc
     *
     * @return text 
     */
    public function getExamDesc()
    {
        return $this->exam_desc;
    }

    /**
     * Set exam_date
     *
     * @param datetime $examDate
     * @return Exam
     */
    public function setExamDate($examDate)
    {
        $this->exam_date = $examDate;
        return $this;
    }

    /**
     * Get exam_date
     *
     * @return datetime 
     */
    public function getExamDate()
    {
        return $this->exam_date;
    }

    /**
     * Set coef
     *
     * @param float $coef
     * @return Exam
     */
    public function setCoef($coef)
    {
        $this->coef = $coef;
        return $this;
    }

    /**
     * Get coef
     *
     * @return float 
     */
    public function getCoef()
    {
        return $this->coef;
    }

    /**
     * Set promo
     *
     * @param Promo $promo
     * @return Exam
     */
    public function setPromo(Promo $promo = null)
    {
        $this->promo = $promo;
        return $this;
    }

    /**
     * Get promo
     *
     * @return Unsapa\IPWBundle\Entity\Promo 
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Set resp
     *
     * @param User $resp
     * @return Exam
     */
    public function setResp(User $resp = null)
    {
        $this->resp = $resp;
        return $this;
    }

    /**
     * Get resp
     *
     * @return Unsapa\IPWBundle\Entity\User 
     */
    public function getResp()
    {
        return $this->resp;
    }
    
    /**
     * Add records
     *
     * @param Record $records
     */
    public function addRecord(Record $records)
    {
        $this->records[] = $records;
    }

    /**
     * Get records
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * Get a french formatted string to print the datetime
     *
     * @return string
     */
    public function getFormatExamDate()
    {
      return ucfirst(strftime("%A %d %B %G", $this->getExamDate()->getTimestamp()));
    }

    /**
     * Get a french formatted string to print the datetime (small version)
     *
     * @return string
     */
    public function getSmallFormatExamDate()
    {
      return ucfirst(strftime("%d/%m/%G", $this->getExamDate()->getTimestamp()));
    }
    /**
     * To string for user
     * 
     * @return String
     */
    public function __toString()
    {
      return $this->getTitle();
    }
}
