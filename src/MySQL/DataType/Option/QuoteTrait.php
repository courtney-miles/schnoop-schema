<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

trait QuoteTrait
{
    /**
     * @see DataTypeInterface::quote()
     */
    public function quote($value)
    {
        return !is_string($value) ? (string) $value : "'" . addslashes($value) . "'";
    }
}
