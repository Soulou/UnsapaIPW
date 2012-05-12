<?php

namespace Unsapa\IPWBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Unsapa\IPWBundle\Entity\Record
 */
class Record
{
    /**
     * @var Unsapa\IPWBundle\Entity\User
     */
    private $student;

    /**
     * @var Unsapa\IPWBundle\Entity\Exam
     */
    private $exam;

    /**
     * @var string $document
     */
    private $document;

    /**
     * @var integer $mark
     */
    private $mark;

    /**
     * @var file $file
     */
    private $file;

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
     * ToString
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
