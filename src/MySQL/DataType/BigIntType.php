<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 19/06/16
 * Time: 9:22 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class BigIntType extends AbstractIntType
{
    const MIN_SIGNED = -9223372036854775808;
    const MAX_SIGNED = 9223372036854775807;
    const MIN_UNSIGNED = 0;
    const MAX_UNSIGNED = 18446744073709551615;

    public function getType()
    {
        return self::TYPE_BIGINT;
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
