<?php

namespace OkulBilisim\EndorsementBundle\Entity\Traits;

/**
 * Class GenericEntityTrait
 * @package OkulBilisim\EndorsementBundle\Entity\Traits\GenericEntityTrait
 */
trait GenericEntityTrait
{
    use BlameableTrait;
    use SoftDeletableTrait;
    use TimestampableTrait;
}
