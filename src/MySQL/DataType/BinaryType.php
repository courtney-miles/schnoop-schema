<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 26/06/16
 * Time: 5:11 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class BinaryType extends AbstractBinaryType
{
    const MAX_LENGTH = 255;

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_BINARY;
    }
    
    public function doesAllowDefault()
    {
        return true;
    }
}
