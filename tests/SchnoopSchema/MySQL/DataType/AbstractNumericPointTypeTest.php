<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\NumericPointTypeTestCase;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractNumericPointType;
use PHPUnit_Framework_MockObject_MockObject;

class AbstractNumericPointTypeTest extends NumericPointTypeTestCase
{
    /**
     * @var AbstractNumericPointType
     */
    protected $abstractNumericPointType;

    protected $type = 'foo';

    public function setUp()
    {
        parent::setUp();

        $this->abstractNumericPointType = $this->createMockAbstractNumericPointType($this->type);
    }

    protected function getNumericPointType()
    {
        return $this->abstractNumericPointType;
    }

    protected function createNumericPointType()
    {
        return $this->createMockAbstractNumericPointType('foo');
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame($this->type, $this->abstractNumericPointType->getType());
    }

    /**
     * @param $type
     * @return AbstractNumericPointType|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockAbstractNumericPointType($type)
    {
        $mockAbstractNumericPointType = $this->getMockForAbstractClass(
            AbstractNumericPointType::class
        );
        $mockAbstractNumericPointType->method('getType')
            ->willReturn($type);

        return $mockAbstractNumericPointType;
    }
}
