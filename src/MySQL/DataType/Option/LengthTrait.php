<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 20/06/16
 * Time: 4:34 PM
 */

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

    /**
     * @param int $length
     */
    protected function setLength($length)
    {
        $this->length = (int)$length;
    }
}