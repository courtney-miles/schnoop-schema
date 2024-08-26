<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\CollationTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

abstract class AbstractTextType implements TextTypeInterface
{
    use CollationTrait;
    use QuoteTrait;

    public function doesAllowDefault()
    {
        return false;
    }

    public function cast($value)
    {
        return (string) $value;
    }

    public function getDDL()
    {
        return implode(
            ' ',
            array_filter(
                [
                    strtoupper($this->getType()),
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
