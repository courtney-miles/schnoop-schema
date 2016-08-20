<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\OptionsTypeTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\SetType;

class SetTypeTest extends OptionsTypeTestCase
{
    /**
     * @var SetType
     */
    protected $setType;

    public function setUp()
    {
        parent::setUp();

        $this->setType = new SetType();
    }

    public function getOptionsType()
    {
        return $this->setType;
    }

    public function createOptionsType()
    {
        return new SetType();
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_SET, $this->setType->getType());
    }

    public function testCast()
    {
        $value = [123];
        $expectedValue = ['123'];

        $this->assertSame($expectedValue, $this->setType->cast($value));
    }
}
