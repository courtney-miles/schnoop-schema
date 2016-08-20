<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\EnumType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\OptionsTypeTestCase;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;

class EnumTypeTest extends OptionsTypeTestCase
{
    /**
     * @var EnumType
     */
    protected $enumType;

    public function setUp()
    {
        parent::setUp();

        $this->enumType = new EnumType();
    }

    public function getOptionsType()
    {
        return $this->enumType;
    }

    public function createOptionsType()
    {
        return new EnumType();
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_ENUM, $this->enumType->getType());
    }
}
