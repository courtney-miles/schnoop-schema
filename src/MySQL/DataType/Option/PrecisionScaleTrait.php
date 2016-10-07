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
     * @see PrecisionScaleInterface::getPrecision()
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * @see PrecisionScaleInterface::hasPrecision()
     */
    public function hasPrecision()
    {
        return $this->precision !== null;
    }

    /**
     * @see PrecisionScaleInterface::getScale()
     */
    public function getScale()
    {
        return $this->scale;
    }

    /**
     * @see PrecisionScaleInterface::hasScale()
     */
    public function hasScale()
    {
        return !empty($this->scale);
    }

    /**
     * @see PrecisionScaleInterface::setPrecisionScale()
     */
    public function setPrecisionScale($precision, $scale = 0)
    {
        $this->precision = $precision !== null ? (int)$precision : null;
        $this->scale = $scale === null ? 0 : $scale;
    }
}
