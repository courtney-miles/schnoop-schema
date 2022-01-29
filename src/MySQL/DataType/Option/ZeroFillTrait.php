<?php

declare(strict_types=1);

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
    public function setZeroFill($zeroFill): void
    {
        $this->zeroFill = $zeroFill;
    }
}
