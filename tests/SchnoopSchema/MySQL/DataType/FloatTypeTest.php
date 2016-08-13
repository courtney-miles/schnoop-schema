<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\FloatType;

class FloatTypeTest extends SchnoopSchemaTestCase
{
    /**
     * @dataProvider constructedProvider
     * @param bool $expectedIsSigned
     * @param int|null $expectedPrecision
     * @param int|null $expectedScale
     * @param string|null $expectedMinRange
     * @param string|null $expectedMaxRange
     * @param string $expectedDDL
     * @param FloatType $actualFloatType
     */
    public function testConstructed(
        $expectedIsSigned,
        $expectedPrecision,
        $expectedScale,
        $expectedMinRange,
        $expectedMaxRange,
        $expectedDDL,
        $actualFloatType
    ) {
        $this->numericPointTypeAsserts(
            DataTypeInterface::TYPE_FLOAT,
            $expectedIsSigned,
            $expectedPrecision,
            $expectedScale,
            $expectedMinRange,
            $expectedMaxRange,
            true,
            $expectedDDL,
            $actualFloatType
        );
    }

    public function testCast()
    {
        $floatType = new FloatType(true);

        $this->assertSame(123.23, $floatType->cast('123.23'));
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
                "FLOAT($precision,$scale)",
                new FloatType($signed, $precision, $scale)
            ],
            [
                $notSigned,
                $precision,
                $scale,
                '0',
                '9999.99',
                "FLOAT($precision,$scale) UNSIGNED",
                new FloatType($notSigned, $precision, $scale)
            ],
            [
                $signed,
                null,
                null,
                null,
                null,
                'FLOAT',
                new FloatType($signed)
            ]
        ];
    }
}
