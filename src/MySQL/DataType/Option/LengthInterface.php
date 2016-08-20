<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface LengthInterface
{
    /**
     * @return int
     */
    public function getLength();

    public function hasLength();
    
    public function setLength($length);
}
