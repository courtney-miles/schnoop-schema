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
     * The number of decimal places used to represent the fractional seconds precision.
     * @return int Precision
     */
    public function getPrecision();

    /**
     * Identify if the type has a precision value set.
     * @return bool True if a precision value is set.
     */
    public function hasPrecision();

    /**
     * Set the number of decimal places used to represent fractional seconds.
     * @param $precision
     * @return mixed
     */
    public function setPrecision($precision);
}
