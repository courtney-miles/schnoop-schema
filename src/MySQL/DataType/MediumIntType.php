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
    public function __construct($displayWidth, $isSigned)
    {
        $minRange = $isSigned ? -8388608 : 0;
        $maxRange = $isSigned ? 8388607 : 16777215;

        parent::__construct($displayWidth, $isSigned, $minRange, $maxRange);
    }

    public function getType()
    {
        return self::TYPE_MEDIUMINT;
    }
}
