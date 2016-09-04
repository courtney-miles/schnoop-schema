<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 20/06/16
 * Time: 4:29 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\CollationTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\LengthTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

abstract class AbstractCharType implements CharTypeInterface
{
    use CollationTrait;
    use LengthTrait;
    use QuoteTrait;

    public function __construct($length)
    {
        $this->setLength($length);
    }

    public function cast($value)
    {
        return (string)$value;
    }

    public function doesAllowDefault()
    {
        return true;
    }

    public function __toString()
    {
        return implode(
            ' ',
            array_filter(
                [
                    strtoupper($this->getType()) . ($this->hasLength() ? '(' . $this->getLength() . ')' : null),
                    $this->hasCollation() ? "COLLATE '" . addslashes($this->getCollation()) . "'" : null
                ]
            )
        );
    }
}
