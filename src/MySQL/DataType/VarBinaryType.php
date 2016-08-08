<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 26/06/16
 * Time: 5:12 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class VarBinaryType extends AbstractBinaryType
{
    const MAX_LENGTH = 65535;

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_VARBINARY;
    }

    public function doesAllowDefault()
    {
        return true;
    }
}