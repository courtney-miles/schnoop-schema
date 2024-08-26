<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 20/06/16
 * Time: 4:29 PM.
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

    /**
     * AbstractCharType constructor.
     *
     * @param int $length character length
     */
    public function __construct($length)
    {
        $this->setLength($length);
    }

    public function cast($value)
    {
        return (string) $value;
    }

    public function doesAllowDefault()
    {
        return true;
    }

    public function getDDL()
    {
        return implode(
            ' ',
            array_filter(
                [
                    strtoupper($this->getType()) . ($this->hasLength() ? '(' . $this->getLength() . ')' : null),
                    $this->hasCollation() ? "COLLATE '" . addslashes($this->getCollation()) . "'" : null,
                ]
            )
        );
    }

    public function __toString()
    {
        return $this->getDDL();
    }
}
