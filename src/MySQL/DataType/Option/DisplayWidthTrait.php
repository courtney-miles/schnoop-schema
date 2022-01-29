<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 18/06/16
 * Time: 11:35 AM.
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait DisplayWidthTrait
{
    /**
     * Display width.
     *
     * @var int
     */
    protected $displayWidth;

    /**
     * @see DisplayWidthInterface::getDisplayWidth()
     */
    public function getDisplayWidth()
    {
        return $this->displayWidth;
    }

    /**
     * @see DisplayWidthInterface::hasDisplayWidth()
     */
    public function hasDisplayWidth()
    {
        return !empty($this->displayWidth);
    }

    /**
     * @see DisplayWidthInterface::setDisplayWidth()
     */
    public function setDisplayWidth($displayWidth): void
    {
        $this->displayWidth = (int) $displayWidth;
    }
}
