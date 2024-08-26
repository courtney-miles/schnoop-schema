<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractNumericPointType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\NumericPointTypeTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class AbstractNumericPointTypeTest extends NumericPointTypeTestCase
{
    /**
     * @var AbstractNumericPointType
     */
    protected $abstractNumericPointType;

    protected $type = 'foo';

    public function setUp(): void
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

    public function testInitialProperties(): void
    {
        parent::testInitialProperties();
        $this->assertSame($this->type, $this->abstractNumericPointType->getType());
    }

    /**
     * @return AbstractNumericPointType|MockObject
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
