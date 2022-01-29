<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\CollationTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

abstract class AbstractTextType implements TextTypeInterface
{
    use CollationTrait;
    use QuoteTrait;

    /**
     * {@inheritdoc}
     */
    public function doesAllowDefault()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function cast($value)
    {
        return (string) $value;
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getDDL();
    }
}
