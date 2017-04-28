<?php

namespace Vipa\EndorsementBundle\Entity\Traits;

/**
 * Class GenericEntityTrait
 * @package Vipa\EndorsementBundle\Entity\Traits\GenericEntityTrait
 */
trait GenericEntityTrait
{
    use BlameableTrait;
    use SoftDeletableTrait;
    use TimestampableTrait;
}
