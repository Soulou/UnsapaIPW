<?php
/**
 * Record.php
 *
 * @date 04/24/2012
 * @package Unsapa\IPWBundle\Entity
 */

namespace Unsapa\IPWBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Unsapa\IPWBundle\Entity\Record
 * Create to manage when a user wants to give his work
 */
class Record
{
    /**
     * Part of the primary key
     * Student concerned by this record
     * @var Unsapa\IPWBundle\Entity\User
     */
    private $student;

    /**
     * Part of the primary key
     * Exam concerned by this record
     * @var Unsapa\IPWBundle\Entity\Exam
     */
    private $exam;

    /**
     * Path to the file that the user send
     * @var string $document
     */
    private $document;

    /**
     * Mark chosen by the td manager, responsable of the exam
     * @var integer $mark
     */
    private $mark;

    /**
     * Not stored in the database
     * Object File used during the upload and the download
     * @var file $file
     */
    private $file;

    /**
     * Main constructor for a record
     * @param values $values Attributes of the entity
     */
    public function __construct(array $values = array())
    {
        if(isset($values['student']))
            $this->student = $values['student'];
        if(isset($values['exam']))
            $this->exam = $values['exam'];
        if(isset($values['document']))
            $this->document = $values['document'];
        if(isset($values['mark']))
            $this->mark = $values['mark'];
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
     * Set student
     *
     * @param User $student
     * @return Record
     */
    public function setStudent(User $student = null)
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
     * @param Exam $exam
     * @return Record
     */
    public function setExam(Exam $exam = null)
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
     * Get File
     *
     * @return file
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set File
     * @param $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Event, before adding a document
     */ 
    public function preUpload()
    {
        if(null !== $this->file)
        {
            $this->document = $this->getDocumentName();
        }
    }

    /**
     * Event, during the upload
     */ 
    public function upload()
    {
        if(null === $this->file)
        {
            return;
        }
        $this->file->move($this->getDocumentUploadRootDir(), $this->document);
        unset($this->file);
    }

    /**
     * When deleting a record
     */
    public function removeUpload()
    {
        if($file = $this->getDocumentAbsolutePath())
        {
            unset($file);
        }
    }

    /**
     * Get filename of the document linked to the record
     *
     * @return string
     **/
    public function getDocumentName()
    {
      if($this->file !== NULL)
      {
        $a_origname = explode('.', $this->file->getClientOriginalName());
        return sha1($this->file)
          . "." . $a_origname[count($a_origname)-1];
      }
      return NULL;
    }


    /**
     * Get absolute path
     *
     * @return string
     **/
    public function getDocumentAbsolutePath()
    {
        return $this->getDocumentUploadRootDir().'/'.$this->getDocument();
    }

    /**
     * Get Web path
     *
     * @return string
     **/
    public function getDocumentWebPath()
    {
        return $this->getUploadDir().'/'.$this->getDocument();
    }

    /**
     * Get absolute path to upload dir
     *
     * @return string
     **/
    protected function getDocumentUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getDocumentUploadDir();
    }

    /**
     * Get relative path to upload dir
     *
     * @return string
     **/
    protected function getDocumentUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/records';
    }

    /**
     * Return the json representation of the record
     * @return String
     */
    public function __toString()
    {
      return json_encode(
        array('exam' => $this->exam->getId(),
              'student' => $this->student->getId(),
              'mark' => $this->mark,
              'document' => isset($this->document)));
    }
}
