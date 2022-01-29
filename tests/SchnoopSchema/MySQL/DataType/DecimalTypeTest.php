<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DecimalType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\NumericPointTypeTestCase;

class DecimalTypeTest extends NumericPointTypeTestCase
{
    /**
     * @var DecimalType
     */
    protected $decimalType;

    public function setUp(): void
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

    public function testCast(): void
    {
        $decimalType = new DecimalType();

        $this->assertSame('123.45', $decimalType->cast(123.45));
    }
}
