<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface LengthInterface
{
    /**
     * Get the length of the type.
     * @return int Character length.
     */
    public function getLength();

    /**
     * Identify if a length has been set.
     * @return bool True if a length has been set.
     */
    public function hasLength();

    /**
     * Set the length for the type.
     * @param int $length Character length.
     */
    public function setLength($length);
}
