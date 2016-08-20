<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\CollationTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

abstract class AbstractOptionsType implements OptionsTypeInterface
{
    use CollationTrait;
    use QuoteTrait;

    protected $options = [];

    public function getOptions()
    {
        return $this->options;
    }

    public function hasOptions()
    {
        return !empty($this->options);
    }

    public function hasOption($option)
    {
        return in_array($option, $this->options);
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return bool
     */
    public function doesAllowDefault()
    {
        return true;
    }

    public function cast($value)
    {
        return (string)$value;
    }

    public function __toString()
    {
        return implode(
            ' ',
            array_filter(
                [
                    strtoupper($this->getType()) . "(" . $this->prepareOptionsDDL($this->getOptions()) . ")",
                    $this->hasCollation() ? 'COLLATE ' . $this->getCollation() : null
                ]
            )
        );
    }

    protected function prepareOptionsDDL(array $options)
    {
        $escapedOptions = [];

        foreach ($options as $option) {
            $escapedOptions[] = $this->quote((string)$option);
        }

        return implode(',', $escapedOptions);
    }
}
