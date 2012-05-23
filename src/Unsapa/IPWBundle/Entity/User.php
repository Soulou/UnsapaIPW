<?php
/**
 * User.php
 * 
 * @date 04/24/2012
 * @package Unsapa\IPWBundle\Entity
 */

namespace Unsapa\IPWBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Unsapa\IPWBundle\Entity\User
 * Inheritated user fomr the FOSUserBundle where are include the other fields
 * Password/Username/Email/Roles etc.
 */
class User extends BaseUser
{
    /**
     * Identifier of the user
     * @var integer $id
     */
    protected $id;

    /**
     * Lastname of the user
     * @var string $lastname
     */
    private $lastname;

    /**
     * Firstname of the user
     * @var string $firstname
     */
    private $firstname;

    /**
     * Promotion which contains the user
     * @var Unsapa\IPWBundle\Entity\Promo
     */
    private $promo;

    /**
     * Address of the user
     * @var string $address
     */
    private $address;

    /**
     * Zip code of the address' user
     * @var string $zipcode
     */
    private $zipcode;

    /**
     * City of the address' user
     * @var string $city
     */
    private $city;

    /**
     * Phone number of the user
     * @var string $phone
     */
    private $phone;


    /**
     * The user object must be created with FOSUserBundle UserManager
     * 'fos_user.user_manager', method : createUser()
     * @param array $values Attributes of the user
     */
    public function initUser(array $values = array())
    {
      if(isset($values['username']))
        $this->setUsername($values['username']);
      if(isset($values['password']))
        $this->setPassword($values['password']);
      if(isset($values['email']))
        $this->setEmail($values['email']);
      if(isset($values['firstname']))
        $this->setFirstname($values['firstname']);
      if(isset($values['lastname']))
        $this->setLastname($values['lastname']);
      if(isset($values['address']))
        $this->setAddress($values['address']);
      if(isset($values['zipcode']))
        $this->setZipCode($values['zipcode']);
      if(isset($values['city']))
        $this->setCity($values['city']);
      if(isset($values['promo']))
        $this->setPromo($values['promo']);
    
      $this->setEnabled(true);
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
     * Doctrine call this method on the event 'onPersist'
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
     * Set promo
     *
     * @param Promo $promo
     * @return User
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
    public function getCurrent()
    {
      return "";
    }
}
