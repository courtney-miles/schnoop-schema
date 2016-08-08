<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 20/06/16
 * Time: 4:31 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface LengthInterface
{
    /**
     * @return int
     */
    public function getLength();
}