<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface LengthInterface
{
    /**
     * Get the length of the type.
     *
     * @return int character length
     */
    public function getLength();

    /**
     * Identify if a length has been set.
     *
     * @return bool true if a length has been set
     */
    public function hasLength();

    /**
     * Set the length for the type.
     *
     * @param int $length character length
     */
    public function setLength($length);
}
