<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface OptionsInterface
{
    /**
     * Get the options for the type.
     *
     * @return array options
     */
    public function getOptions();

    /**
     * Identify if any options are set.
     *
     * @return bool true if options are set
     */
    public function hasOptions();

    /**
     * Identify if the specified value exists as an option.
     *
     * @param string $option option value
     *
     * @return bool true if the option value exists
     */
    public function hasOption($option);

    /**
     * Set the options.
     *
     * @param array $options Options
     */
    public function setOptions(array $options);

    /**
     * Add an value to the options.
     *
     * @param string $option
     */
    public function addOption($option);
}
