<?php

namespace Ojs\EndorsementBundle\Entity\Traits;

/**
 * Class GenericEntityTrait
 * @package Ojs\EndorsementBundle\Entity\Traits\GenericEntityTrait
 */
trait GenericEntityTrait
{
    use BlameableTrait;
    use SoftDeletableTrait;
    use TimestampableTrait;
}
