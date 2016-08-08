<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 11/07/16
 * Time: 4:16 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;


class TimeType extends AbstractTimeType
{
    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_TIME;
    }
}