<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 18/06/16
 * Time: 11:35 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait DisplayWidthTrait
{
    /**
     * @var int
     */
    protected $displayWidth;

    /**
     * @return int
     */
    public function getDisplayWidth()
    {
        return $this->displayWidth;
    }

    /**
     * @param int $displayWidth
     */
    protected function setDisplayWidth($displayWidth)
    {
        $this->displayWidth = (int)$displayWidth;
    }
}