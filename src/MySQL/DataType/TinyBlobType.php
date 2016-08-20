<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 23/06/16
 * Time: 7:32 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class TinyBlobType extends AbstractBlobType
{
    const LENGTH = 255;

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_TINYBLOB;
    }
}
