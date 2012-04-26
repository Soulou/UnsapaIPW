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
     * @var text $exam_desc
     */
    private $exam_desc;

    /**
     * @var datetime $exam_date
     */
    private $exam_date;

    /**
     * @var float $coef
     */
    private $coef;

    /**
     * @var Unsapa\IPWBundle\Entity\Promo
     */
    private $promo;


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
     * @param Unsapa\IPWBundle\Entity\Promo $promo
     * @return Exam
     */
    public function setPromo(\Unsapa\IPWBundle\Entity\Promo $promo = null)
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
}