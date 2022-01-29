<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface ZeroFillInterface
{
    /**
     * Identify if values will be zero-filled on display.
     *
     * @return bool true if values will be zero-filled
     */
    public function isZeroFill();

    /**
     * Set if values should be zero-filled on display.
     *
     * @param bool $zeroFill set to true to zero-fill values, otherwise false
     */
    public function setZeroFill($zeroFill);
}
