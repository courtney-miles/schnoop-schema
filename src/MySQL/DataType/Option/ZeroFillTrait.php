<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait ZeroFillTrait
{
    protected $zeroFill = false;

    /**
     * @return boolean
     */
    public function isZeroFill()
    {
        return $this->zeroFill;
    }

    /**
     * @param boolean $zeroFill
     */
    public function setZeroFill($zeroFill)
    {
        $this->zeroFill = $zeroFill;
    }
}
