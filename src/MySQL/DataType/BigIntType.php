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
    const MIN_RANGE_SIGNED = -9223372036854775808;
    const MAX_RANGE_SIGNED = 9223372036854775807;
    const MIN_RANGE_UNSIGNED = 0;
    const MAX_RANGE_UNSIGNED = 18446744073709551615;

    public function __construct($displayWidth, $isSigned)
    {
        $minRange = $isSigned ? self::MIN_RANGE_SIGNED : self::MIN_RANGE_UNSIGNED;
        $maxRange = $isSigned ? self::MAX_RANGE_SIGNED : self::MAX_RANGE_UNSIGNED;

        parent::__construct($displayWidth, $isSigned, $minRange, $maxRange);
    }

    public function getType()
    {
        return self::TYPE_BIGINT;
    }
}
