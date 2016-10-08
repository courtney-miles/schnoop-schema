<?php

namespace MilesAsylum\SchnoopSchema\MySQL;

interface HasDefinerInterface
{
    /**
     * Get the resource definer.
     * @return string
     */
    public function getDefiner();

    /**
     * Identify if a definer is set for the resource.
     * @return mixed True if a definer is set.
     */
    public function hasDefiner();

    /**
     * Set the definer for resource.
     * @param string $definer
     */
    public function setDefiner($definer);
}
