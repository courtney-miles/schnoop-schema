<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface SignedInterface
{
    /**
     * Identify if the type allows signed values (i.e. negative values.)
     * @return mixed
     */
    public function isSigned();

    /**
     * Set if the type allows signed values
     * @param bool $signed Set to true to allow signed values, false otherwise.
     */
    public function setSigned($signed);
}
