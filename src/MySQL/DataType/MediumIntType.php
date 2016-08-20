<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 19/06/16
 * Time: 9:21 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class MediumIntType extends AbstractIntType
{
    const MIN_SIGNED = -8388608;
    const MAX_SIGNED = 8388607;
    const MIN_UNSIGNED = 0;
    const MAX_UNSIGNED = 16777215;

    public function getType()
    {
        return self::TYPE_MEDIUMINT;
    }

    public function getMinRange()
    {
        return $this->isSigned() ? self::MIN_SIGNED : self::MIN_UNSIGNED;
    }

    public function getMaxRange()
    {
        return $this->isSigned() ? self::MAX_SIGNED : self::MAX_UNSIGNED;
    }
}
