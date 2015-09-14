<?php

namespace OkulBilisim\EndorsementBundle\Entity;

use OkulBilisim\EndorsementBundle\Entity\Traits\GenericEntityTrait;

/**
 * Class Skill
 * @package OkulBilisim\EndorsementBundle\Entity
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
}
