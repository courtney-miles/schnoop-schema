<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface ZeroFillInterface
{
    /**
     * @return bool
     */
    public function isZeroFill();

    /**
     * @param bool $zeroFill
     */
    public function setZeroFill($zeroFill);
}
