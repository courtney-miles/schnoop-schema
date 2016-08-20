<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\NumericPointTypeTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DecimalType;

class DecimalTypeTest extends NumericPointTypeTestCase
{
    /**
     * @var DecimalType
     */
    protected $decimalType;

    public function setUp()
    {
        parent::setUp();

        $this->decimalType = new DecimalType();
    }

    protected function getNumericPointType()
    {
        return $this->decimalType;
    }

    protected function createNumericPointType()
    {
        return new DecimalType();
    }

    public function testCast()
    {
        $decimalType = new DecimalType();

        $this->assertSame('123.45', $decimalType->cast(123.45));
    }
}
