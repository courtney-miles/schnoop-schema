<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 18/06/16
 * Time: 11:25 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class IntType extends AbstractIntType
{
    public function __construct($displayWidth, $isSigned)
    {
        $minRange = $isSigned ? -2147483648 : 0;
        $maxRange = $isSigned ? 2147483647 : 4294967295;
        
        parent::__construct($displayWidth, $isSigned, $minRange, $maxRange);
    }

    public function getType()
    {
        return self::TYPE_INT;
    }
}