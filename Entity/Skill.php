<?php

namespace Vipa\EndorsementBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Vipa\EndorsementBundle\Entity\Traits\GenericEntityTrait;
use Vipa\UserBundle\Entity\User;

/**
 * Class Skill
 * @package Vipa\EndorsementBundle\Entity
 */
class Skill
{
    use GenericEntityTrait;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * Skill constructor.
     */
    public function __construct()
    {
        $this->skillUsers = new ArrayCollection();
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Skill
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
