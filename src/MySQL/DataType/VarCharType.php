<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 20/06/16
 * Time: 8:46 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class VarCharType extends AbstractStringType
{
    const MAX_LENGTH = 65535;

    public function __construct($length, $collation = null)
    {
        parent::__construct($length, $collation);
    }

    public function getType()
    {
        return self::TYPE_VARCHAR;
    }
    
    public function doesAllowDefault()
    {
        return true;
    }
}