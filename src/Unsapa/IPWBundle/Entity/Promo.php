<?php
/**
 * Promo.php
 *
 * @date 04/24/2012
 * @package Unsapa\IPWBundle\ENtity
 */

namespace Unsapa\IPWBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Unsapa\IPWBundle\Entity\Promo
 */
class Promo
{
    /**
     * Identifier of the promotion
     * @var integer $id
     */
    private $id;

    /**
     * Name of this promotion
     * @var string $name
     */
    private $name;


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
     * Set name
     *
     * @param string $name
     * @return Promo
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
      return $this->getName();
    }
}
