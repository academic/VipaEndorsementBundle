<?php

namespace OkulBilisim\EndorsementBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use OkulBilisim\EndorsementBundle\Entity\Traits\GenericEntityTrait;
use Ojs\UserBundle\Entity\User;

/**
 * Class UserEndorse
 * @package OkulBilisim\EndorsementBundle\Entity
 */
class UserEndorse
{
    use GenericEntityTrait;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Skill
     */
    private $skill;

    /**
     * @var User
     */
    private $endorser;

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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function getEndorser()
    {
        return $this->endorser;
    }

    /**
     * @param User $endorser
     * @return $this
     */
    public function setEndorser(User $endorser)
    {
        $this->endorser = $endorser;
        return $this;
    }

    /**
     * @return Skill
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * @param Skill $skill
     * @return $this
     */
    public function setSkill(Skill $skill)
    {
        $this->skill = $skill;
        return $this;
    }
}
