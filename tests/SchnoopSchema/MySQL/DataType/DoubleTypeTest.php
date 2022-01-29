<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DoubleType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\NumericPointTypeTestCase;

class DoubleTypeTest extends NumericPointTypeTestCase
{
    /**
     * @var DoubleType
     */
    protected $doubleType;

    public function setUp(): void
    {
        parent::setUp();

        $this->doubleType = new DoubleType();
    }

    protected function getNumericPointType()
    {
        return $this->doubleType;
    }

    protected function createNumericPointType()
    {
        return new DoubleType();
    }

    public function testCast(): void
    {
        $doubleType = new DoubleType();

        $this->assertSame(123.45, $doubleType->cast(123.45));
    }
}
