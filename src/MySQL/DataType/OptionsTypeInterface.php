<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 11/07/16
 * Time: 7:26 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\CollationInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\OptionsInterface;

interface OptionsTypeInterface extends DataTypeInterface, OptionsInterface, CollationInterface
{

}