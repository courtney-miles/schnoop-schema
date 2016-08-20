<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait LengthTrait
{
    /**
     * @var int
     */
    protected $length;

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    public function hasLength()
    {
        return !empty($this->length);
    }

    /**
     * @param int $length
     */
    public function setLength($length)
    {
        $this->length = (int)$length;
    }
}
