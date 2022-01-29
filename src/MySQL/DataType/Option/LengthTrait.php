<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait LengthTrait
{
    /**
     * @var int
     */
    protected $length;

    /**
     * @see LengthInterface::getLength()
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @see LengthInterface::hasLength()
     */
    public function hasLength()
    {
        return !empty($this->length);
    }

    /**
     * @see LengthInterface::setLength()
     */
    public function setLength($length): void
    {
        $this->length = (int) $length;
    }
}
