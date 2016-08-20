<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 11/07/16
 * Time: 4:12 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

interface TimeTypeInterface extends DataTypeInterface
{
    /**
     * The number of decimals used to represent the fractional seconds precision.
     * @return int
     */
    public function getPrecision();

    public function hasPrecision();

    public function setPrecision($precision);
}
