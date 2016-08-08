<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 18/06/16
 * Time: 6:18 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait NumericRangeTrait
{
    /**
     * @var int
     */
    protected $minRange;

    /**
     * @var int
     */
    protected $maxRange;

    /**
     * @return int
     */
    public function getMinRange()
    {
        return $this->minRange;
    }
    
    /**
     * @return int
     */
    public function getMaxRange()
    {
        return $this->maxRange;
    }

    /**
     * @param int $minRange
     * @param int $maxRange
     */
    protected function setRange($minRange, $maxRange)
    {
        $this->minRange = $minRange;
        $this->maxRange = $maxRange;
    }
}