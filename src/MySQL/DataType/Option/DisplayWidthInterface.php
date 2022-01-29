<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 18/06/16
 * Time: 6:34 PM.
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface DisplayWidthInterface
{
    /**
     * Get the display width.
     *
     * @return int display width
     */
    public function getDisplayWidth();

    /**
     * Identify if the display width is set.
     *
     * @return bool
     */
    public function hasDisplayWidth();

    /**
     * Set the display width.
     *
     * @param int $displayWidth Display width
     */
    public function setDisplayWidth($displayWidth);
}
