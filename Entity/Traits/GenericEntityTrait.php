<?php

namespace BulutYazilim\EndorsementBundle\Entity\Traits;

/**
 * Class GenericEntityTrait
 * @package BulutYazilim\EndorsementBundle\Entity\Traits\GenericEntityTrait
 */
trait GenericEntityTrait
{
    use BlameableTrait;
    use SoftDeletableTrait;
    use TimestampableTrait;
}
