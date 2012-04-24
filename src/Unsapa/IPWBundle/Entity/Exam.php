<?php

namespace Unsapa\IPWBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Unsapa\IPWBundle\Entity\Exam
 */
class Exam
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var text $desc
     */
    private $desc;

    /**
     * @var integer $promo
     */
    private $promo;

    /**
     * @var date $exam_date
     */
    private $exam_date;

    /**
     * @var float $coef
     */
    private $coef;


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
     * Set desc
     *
     * @param text $desc
     * @return Exam
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
        return $this;
    }

    /**
     * Get desc
     *
     * @return text 
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * Set promo
     *
     * @param integer $promo
     * @return Exam
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;
        return $this;
    }

    /**
     * Get promo
     *
     * @return integer 
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Set exam_date
     *
     * @param date $examDate
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
     * @return date 
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
}