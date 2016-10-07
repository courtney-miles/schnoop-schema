<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface OptionsInterface
{
    /**
     * Get the options for the type.
     * @return array Options.
     */
    public function getOptions();

    /**
     * Identify if any options are set.
     * @return bool True if options are set.
     */
    public function hasOptions();

    /**
     * Identify if the specified value exists as an option.
     * @param string $option Option value.
     * @return bool True if the option value exists.
     */
    public function hasOption($option);

    /**
     * Set the options.
     * @param array $options Options
     */
    public function setOptions(array $options);

    /**
     * Add an value to the options.
     * @param string $option
     */
    public function addOption($option);
}
