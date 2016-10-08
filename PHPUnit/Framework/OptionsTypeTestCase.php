<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\DataType\OptionsTypeInterface;

abstract class OptionsTypeTestCase extends DataTypeTestCase
{
    /**
     * @return OptionsTypeInterface
     */
    abstract protected function getOptionsType();

    /**
     * @return OptionsTypeInterface
     */
    abstract protected function createOptionsType();

    public function testInitialProperties()
    {
        $optionsType = $this->getOptionsType();

        $this->assertFalse($optionsType->hasOptions());
        $this->assertSame([], $optionsType->getOptions());

        $this->assertFalse($optionsType->hasCollation());
        $this->assertNull($optionsType->getCollation());

        $this->assertTrue($optionsType->doesAllowDefault());
    }

    public function testSetOptions()
    {
        $options = ['abc', 123];

        $optionsType = $this->getOptionsType();
        $optionsType->setOptions(['abc', 123]);

        $this->assertTrue($optionsType->hasOptions());
        $this->assertSame($options, $optionsType->getOptions());

        foreach ($options as $k => $value) {
            $this->assertTrue($optionsType->hasOption($options[$k]));
        }

        return [$optionsType, $options];
    }

    /**
     * @depends testSetOptions
     * @param array $testData
     */
    public function testAddOption(array $testData)
    {
        /** @var OptionsTypeInterface $optionsType */
        list($optionsType, $presetOptions) = $testData;

        $newOption = 'foo';
        $expectedOptions = $presetOptions;
        $expectedOptions[] = $newOption;

        $optionsType->addOption($newOption);

        $this->assertSame($expectedOptions, $optionsType->getOptions());

        foreach ($expectedOptions as $k => $value) {
            $this->assertTrue($optionsType->hasOption($expectedOptions[$k]));
        }
    }

    public function testSetCollation()
    {
        $collation = 'utf8mb4_general_ci';
        $optionsType = $this->getOptionsType();
        $optionsType->setCollation($collation);

        $this->assertTrue($optionsType->hasCollation());
        $this->assertSame($collation, $optionsType->getCollation());
    }

    public function testCast()
    {
        $optionsType = $this->getOptionsType();

        $this->assertSame('123', $optionsType->cast(123));
    }

    public function DDLProvider()
    {
        $simpleOptions = array('abc', '123');

        $optionsType = $this->createOptionsType();
        $optionsType->setOptions($simpleOptions);

        return [
            [
                strtoupper($optionsType->getType()) . "('abc','123')",
                $optionsType
            ]
        ];
    }
}
