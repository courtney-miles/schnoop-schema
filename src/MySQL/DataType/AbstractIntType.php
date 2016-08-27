<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\DisplayWidthTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\SignedTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\ZeroFillTrait;

abstract class AbstractIntType implements IntTypeInterface
{
    use DisplayWidthTrait;
    use SignedTrait;
    use QuoteTrait;
    use ZeroFillTrait;
    
    public function __construct()
    {
        $this->setSigned(true);
    }

    public function doesAllowDefault()
    {
        return true;
    }

    public function cast($value)
    {
        return (int)$value;
    }

    public function __toString()
    {
        return implode(
            ' ',
            array_filter(
                [
                    strtoupper($this->getType()) . ($this->displayWidth > 0 ? '(' . $this->displayWidth .')' : null),
                    !$this->isSigned() ? 'UNSIGNED' : null
                ]
            )
        );
    }
}
