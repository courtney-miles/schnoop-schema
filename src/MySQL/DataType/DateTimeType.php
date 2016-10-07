<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 11/07/16
 * Time: 4:23 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class DateTimeType extends AbstractTimeType
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_DATETIME;
    }
}
