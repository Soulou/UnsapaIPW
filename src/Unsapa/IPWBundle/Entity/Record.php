<?php

namespace Unsapa\IPWBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Unsapa\IPWBundle\Entity\Record
 */
class Record
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $mark
     */
    private $mark;


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
     * Set mark
     *
     * @param integer $mark
     * @return Record
     */
    public function setMark($mark)
    {
        $this->mark = $mark;
        return $this;
    }

    /**
     * Get mark
     *
     * @return integer 
     */
    public function getMark()
    {
        return $this->mark;
    }
    /**
     * @var Unsapa\IPWBundle\Entity\User
     */
    private $student;

    /**
     * @var Unsapa\IPWBundle\Entity\Exam
     */
    private $exam;


    /**
     * Set student
     *
     * @param Unsapa\IPWBundle\Entity\User $student
     * @return Record
     */
    public function setStudent(\Unsapa\IPWBundle\Entity\User $student = null)
    {
        $this->student = $student;
        return $this;
    }

    /**
     * Get student
     *
     * @return Unsapa\IPWBundle\Entity\User 
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set exam
     *
     * @param Unsapa\IPWBundle\Entity\Exam $exam
     * @return Record
     */
    public function setExam(\Unsapa\IPWBundle\Entity\Exam $exam = null)
    {
        $this->exam = $exam;
        return $this;
    }

    /**
     * Get exam
     *
     * @return Unsapa\IPWBundle\Entity\Exam 
     */
    public function getExam()
    {
        return $this->exam;
    }
    /**
     * @var string $document
     */
    private $document;

    /**
     * @var string $state
     */
    private $state;


    /**
     * Set document
     *
     * @param string $document
     * @return Record
     */
    public function setDocument($document)
    {
        $this->document = $document;
        return $this;
    }

    /**
     * Get document
     *
     * @return string 
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Record
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }
}