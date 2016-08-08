<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 20/06/16
 * Time: 4:29 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\CollationTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteStringTrait;

abstract class AbstractStringType implements StringTypeInterface
{
    use CollationTrait;
    use QuoteStringTrait;
    
    /**
     * @var int
     */
    protected $length;

    public function __construct($length, $collation = null)
    {
        $this->setLength($length);
        $this->setCollation($collation);
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    public function cast($value)
    {
        return (string)$value;
    }

    public function __toString()
    {
        return implode(
            ' ',
            array_filter(
                [
                    strtoupper($this->getType()) . '(' . $this->length . ')',
                    $this->hasCollation() ? "COLLATE '" . addslashes($this->getCollation()) . "'" : null
                ]
            )
        );
    }

    /**
     * @param int $length
     */
    protected function setLength($length)
    {
        $this->length = (int)$length;
    }
}
