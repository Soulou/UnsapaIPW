<?php

namespace Unsapa\IPWBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Unsapa\IPWBundle\Entity\User
 */
class User extends BaseUser
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $lastname
     */
    private $lastname;

    /**
     * @var string $firstname
     */
    private $firstname;

    /**
     * @var string $address
     */
    private $address;

    /**
     * @var string $zipcode
     */
    private $zipcode;

    /**
     * @var string $city
     */
    private $city;

    /**
     * @var string $phone
     */
    private $phone;


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
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return User
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string 
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set default role to ROLE_STUDENT
     * 
     */
    public function setDefaultRole()
    {
      $this->addRole("ROLE_STUDENT");
    }

    /**
     * To string for User
     *
     * @return String
     */
    public function __toString()
    {
      return $this->getLastname() . " " . $this->getFirstname();
    }
    /**
     * @var Unsapa\IPWBundle\Entity\Promo
     */
    private $promo;


    /**
     * Set promo
     *
     * @param Unsapa\IPWBundle\Entity\Promo $promo
     * @return User
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
