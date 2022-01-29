<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\FloatType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\NumericPointTypeTestCase;

class FloatTypeTest extends NumericPointTypeTestCase
{
    /**
     * @var FloatType
     */
    protected $floatType;

    public function setUp(): void
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

    public function testInitialProperties(): void
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_FLOAT, $this->floatType->getType());
    }

    public function testCast(): void
    {
        $floatType = new FloatType();

        $this->assertSame(123.45, $floatType->cast(123.45));
    }
}
