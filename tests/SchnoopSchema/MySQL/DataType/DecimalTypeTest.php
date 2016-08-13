<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DecimalType;

class DecimalTypeTest extends SchnoopSchemaTestCase
{
    /**
     * @dataProvider constructedProvider
     * @param bool $expectedIsSigned
     * @param int|null $expectedPrecision
     * @param int|null $expectedScale
     * @param string|null $expectedMinRange
     * @param string|null $expectedMaxRange
     * @param string $expectedDDL
     * @param DecimalType $actualDecimalType
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
            DataTypeInterface::TYPE_DECIMAL,
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
        $decimalType = new DecimalType(true, 10, 0);

        $this->assertSame('123.45', $decimalType->cast(123.45));
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
                "DECIMAL($precision,$scale)",
                new DecimalType($signed, $precision, $scale)
            ],
            [
                $notSigned,
                $precision,
                $scale,
                '0',
                '9999.99',
                "DECIMAL($precision,$scale) UNSIGNED",
                new DecimalType($notSigned, $precision, $scale)
            ]
        ];
    }
}
