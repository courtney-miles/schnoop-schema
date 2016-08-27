<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\NumericPointTypeTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\FloatType;

class FloatTypeTest extends NumericPointTypeTestCase
{
    /**
     * @var FloatType
     */
    protected $floatType;

    public function setUp()
    {
        parent::setUp();

        $this->floatType = new FloatType();
    }

    protected function getNumericPointType()
    {
        return $this->floatType;
    }

    protected function createNumericPointType()
    {
        return new FloatType();
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_FLOAT, $this->floatType->getType());
    }

    public function testCast()
    {
        $floatType = new FloatType();

        $this->assertSame(123.45, $floatType->cast(123.45));
    }
}
