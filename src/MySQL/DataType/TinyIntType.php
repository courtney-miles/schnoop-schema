<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 19/06/16
 * Time: 9:19 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class TinyIntType extends AbstractIntType
{
    public function __construct($displayWidth, $isSigned)
    {
        $minRange = $isSigned ? -128 : 0;
        $maxRange = $isSigned ? 127 : 255;

        parent::__construct($displayWidth, $isSigned, $minRange, $maxRange);
    }

    public function getType()
    {
        return self::TYPE_TINYINT;
    }
}