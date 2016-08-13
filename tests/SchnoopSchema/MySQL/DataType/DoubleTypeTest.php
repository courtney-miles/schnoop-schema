<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DoubleType;

class DoubleTypeTest extends SchnoopSchemaTestCase
{
    /**
     * @dataProvider constructedProvider
     * @param bool $expectedIsSigned
     * @param int|null $expectedPrecision
     * @param int|null $expectedScale
     * @param string|null $expectedMinRange
     * @param string|null $expectedMaxRange
     * @param string $expectedDDL
     * @param DoubleType $actualDecimalType
     */
    public function testConstructed(
        $expectedIsSigned,
        $expectedPrecision,
        $expectedScale,
        $expectedMinRange,
        $expectedMaxRange,
        $expectedDDL,
        $actualDecimalType
    ) {
        $this->numericPointTypeAsserts(
            DataTypeInterface::TYPE_DOUBLE,
            $expectedIsSigned,
            $expectedPrecision,
            $expectedScale,
            $expectedMinRange,
            $expectedMaxRange,
            true,
            $expectedDDL,
            $actualDecimalType
        );
    }

    public function testCast()
    {
        $doubleType = new DoubleType(true);

        $this->assertSame(123.23, $doubleType->cast('123.23'));
    }

    /**
     * @see testConstructed
     * @return array
     */
    public function constructedProvider()
    {
        $signed = true;
        $notSigned = false;
        $precision = 6;
        $scale = 2;

        return [
            [
                $signed,
                $precision,
                $scale,
                '-9999.99',
                '9999.99',
                "DOUBLE($precision,$scale)",
                new DoubleType($signed, $precision, $scale)
            ],
            [
                $notSigned,
                $precision,
                $scale,
                '0',
                '9999.99',
                "DOUBLE($precision,$scale) UNSIGNED",
                new DoubleType($notSigned, $precision, $scale)
            ],
            [
                $signed,
                null,
                null,
                null,
                null,
                "DOUBLE",
                new DoubleType($signed)
            ]
        ];
    }
}
