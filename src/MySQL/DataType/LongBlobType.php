<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 23/06/16
 * Time: 7:34 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class LongBlobType extends AbstractBlobType
{
    const LENGTH = 4294967295;

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_LONGBLOB;
    }
}