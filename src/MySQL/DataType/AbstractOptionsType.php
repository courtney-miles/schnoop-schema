<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\CollationTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\OptionTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

abstract class AbstractOptionsType implements OptionsTypeInterface
{
    use OptionTrait;
    use CollationTrait;
    use QuoteTrait;

    public function __construct(array $options, $collation)
    {
        $this->setOptions($options);
        $this->setCollation($collation);
    }

    /**
     * @return bool
     */
    public function doesAllowDefault()
    {
        return true;
    }

    public function __toString()
    {
        return sprintf(
            "%s(%s) COLLATE %s",
            strtoupper($this->getType()),
            "'" . implode("','", $this->getOptions()) . "'",
            $this->getCollation()
        );
    }
}
