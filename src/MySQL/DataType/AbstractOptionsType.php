<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\CollationTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

abstract class AbstractOptionsType implements OptionsTypeInterface
{
    use CollationTrait;
    use QuoteTrait;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function hasOptions()
    {
        return !empty($this->options);
    }

    /**
     * {@inheritdoc}
     */
    public function hasOption($option)
    {
        return in_array($option, $this->options, true);
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options): void
    {
        $this->options = array_values($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addOption($option): void
    {
        $this->options[] = $option;
    }

    /**
     * {@inheritdoc}
     */
    public function doesAllowDefault()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function cast($value)
    {
        return (string) $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getDDL()
    {
        return implode(
            ' ',
            array_filter(
                [
                    strtoupper($this->getType()) . '(' . $this->makeOptionsDDL($this->getOptions()) . ')',
                    $this->hasCollation() ? 'COLLATE ' . $this->getCollation() : null,
                ]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getDDL();
    }

    /**
     * Make just the portion of the DDL that describes the options.
     *
     * @return string portion of DDL for options
     */
    protected function makeOptionsDDL(array $options)
    {
        $escapedOptions = [];

        foreach ($options as $option) {
            $escapedOptions[] = $this->quote((string) $option);
        }

        return implode(',', $escapedOptions);
    }
}
