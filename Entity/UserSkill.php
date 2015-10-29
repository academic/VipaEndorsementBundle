<?php

namespace OkulBilisim\EndorsementBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use OkulBilisim\EndorsementBundle\Entity\Traits\GenericEntityTrait;
use Ojs\UserBundle\Entity\User;

/**
 * Class UserSkill
 * @package OkulBilisim\EndorsementBundle\Entity
 */
class UserSkill
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
     * @var string
     */
    private $endorsementCount;

    /**
     * @var Collection|UserEndorse[]
     */
    private $userSkillEndorsers;

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

    /**
     * @return string
     */
    public function getEndorsementCount()
    {
        return $this->endorsementCount;
    }

    /**
     * @param string $endorsementCount
     * @return $this
     */
    public function setEndorsementCount($endorsementCount)
    {
        $this->endorsementCount = $endorsementCount;
        return $this;
    }

    /**
     * @return Collection|UserEndorse[]
     */
    public function getUserSkillEndorsers()
    {
        return $this->userSkillEndorsers;
    }

    /**
     * @var Collection|UserEndorse[] $userSkillEndorsers
     * @return $this
     */
    public function setUserSkillEndorsers($userSkillEndorsers)
    {
        $this->userSkillEndorsers = $userSkillEndorsers;
        return $this;
    }
}
