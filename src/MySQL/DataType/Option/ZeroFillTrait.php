<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait ZeroFillTrait
{
    protected $zeroFill = false;

    /**
     * @see ZeroFillInterface::isZeroFill()
     */
    public function isZeroFill()
    {
        return $this->zeroFill;
    }

    /**
     * @see ZeroFillInterface::setZeroFill()
     */
    public function setZeroFill($zeroFill)
    {
        $this->zeroFill = $zeroFill;
    }
}
