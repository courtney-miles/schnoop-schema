<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 20/06/16
 * Time: 4:41 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class CharType extends AbstractStringType
{
    const MAX_LENGTH = 255;

    public function __construct($length, $collation = null)
    {
        parent::__construct($length, $collation);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_CHAR;
    }
    
    public function doesAllowDefault()
    {
        return true;
    }
}