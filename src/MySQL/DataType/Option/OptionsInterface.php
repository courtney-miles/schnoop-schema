<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface OptionsInterface
{
    /**
     * @return array
     */
    public function getOptions();

    public function hasOptions();

    public function hasOption($option);

    public function setOptions(array $options);
}
