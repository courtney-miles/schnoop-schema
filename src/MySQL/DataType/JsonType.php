<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

class JsonType implements DataTypeInterface
{
    use QuoteTrait;

    public function getType()
    {
        return self::TYPE_JSON;
    }

    public function doesAllowDefault()
    {
        return true;
    }

    public function cast($value)
    {
        $json = json_encode($value);

        if ($json === false) {
            throw new \InvalidArgumentException('Supplied value could not be converted to JSON.');
        }

        return $json;
    }

    public function getDDL()
    {
        return strtoupper($this->getType());
    }

    public function __toString()
    {
        return $this->getDDL();
    }
}
