<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface SignedInterface
{
    /**
     * Identify if the type allows signed values (i.e. negative values.).
     */
    public function isSigned();

    /**
     * Set if the type allows signed values.
     *
     * @param bool $signed set to true to allow signed values, false otherwise
     */
    public function setSigned($signed);
}
