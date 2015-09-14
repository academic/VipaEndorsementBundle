<?php

namespace OkulBilisim\EndorsementBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use OkulBilisim\EndorsementBundle\Entity\Traits\GenericEntityTrait;
use Ojs\UserBundle\Entity\User;

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
     * @var ArrayCollection|User[]
     */
    private $skillUsers;

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

    /**
     * @return ArrayCollection|User[]
     */
    public function getSkillUsers()
    {
        return $this->skillUsers;
    }

    /**
     * @param ArrayCollection|User[] $skillUsers
     * @return $this
     */
    public function setSkillUsers($skillUsers)
    {
        $this->skillUsers = $skillUsers;
        return $this;
    }

    /**
     * @param  User $user
     * @return Skill
     */
    public function addSkillUser(User $user)
    {
        if (!$this->skillUsers->contains($user)) {
            $this->skillUsers->add($user);
        }
        return $this;
    }
}
