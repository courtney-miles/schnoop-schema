<?php

namespace MilesAsylum\SchnoopSchema;

interface DataTypeInterface
{
    /**
     * @return string
     */
    public function getType();

    public function __toString();
}
