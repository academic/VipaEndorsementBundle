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
     * @var UserSkill
     */
    private $userSkill;

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
     * @return UserSkill
     */
    public function getUserSkill()
    {
        return $this->userSkill;
    }

    /**
     * @param UserSkill $userSkill
     * @return $this
     */
    public function setUserSkill(UserSkill $userSkill)
    {
        $this->userSkill = $userSkill;
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
}
