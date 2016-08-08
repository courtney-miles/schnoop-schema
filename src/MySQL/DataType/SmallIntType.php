<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 19/06/16
 * Time: 9:21 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class SmallIntType extends AbstractIntType
{
    public function __construct($displayWidth, $isSigned)
    {
        $minRange = $isSigned ? -32768 : 0;
        $maxRange = $isSigned ? 32767 : 65535;

        parent::__construct($displayWidth, $isSigned, $minRange, $maxRange);
    }

    public function getType()
    {
        return self::TYPE_SMALLINT;
    }
}