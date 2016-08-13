<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 19/06/16
 * Time: 9:17 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait PrecisionScaleTrait
{
    /**
     * @var int
     */
    protected $precision;

    /**
     * @var int
     */
    protected $scale;

    /**
     * @return int
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    public function hasPrecision()
    {
        return $this->precision !== null;
    }

    /**
     * @return int
     */
    public function getScale()
    {
        return $this->scale;
    }

    public function hasScale()
    {
        return !empty($this->scale);
    }

    /**
     * @param int $precision
     * @param int $scale
     */
    public function setPrecisionScale($precision, $scale = 0)
    {
        $this->precision = (int)$precision;
        $this->scale = $scale === null ? 0 : $scale;
    }
}
