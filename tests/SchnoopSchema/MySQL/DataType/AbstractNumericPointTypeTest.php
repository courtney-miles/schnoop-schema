<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 19/06/16
 * Time: 10:42 AM
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractNumericPointType;
use PHPUnit_Framework_MockObject_MockObject;

class AbstractNumericPointTypeTest extends SchnoopTestCase
{
    /**
     * @dataProvider constructedProvider()
     * @param $isSigned
     * @param $precision
     * @param $scale
     * @param $type
     * @param $expectedMinRange
     * @param $expectedMaxRange
     * @param $expectedDoesAllowNull
     * @param $expectedDDL
     */
    public function testConstructed(
        $isSigned,
        $precision,
        $scale,
        $type,
        $expectedMinRange,
        $expectedMaxRange,
        $expectedDoesAllowNull,
        $expectedDDL
    ) {
        $abstractNumericPointType = $this->createMockAbstractNumericPointType(
            $type,
            $isSigned,
            $precision,
            $scale
        );

        $this->numericPointTypeAsserts(
            $type,
            $isSigned,
            $precision,
            $scale,
            $expectedMinRange,
            $expectedMaxRange,
            $expectedDoesAllowNull,
            $expectedDDL,
            $abstractNumericPointType
        );
    }

    /**
     * @see testConstructed()
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
                'foo',
                '-9999.99',
                '9999.99',
                true,
                "FOO($precision,$scale)"
            ],
            [
                $notSigned,
                $precision,
                $scale,
                'foo',
                '0',
                '9999.99',
                true,
                "FOO($precision,$scale) UNSIGNED"
            ]
        ];
    }

    /**
     * @param $type
     * @param $signed
     * @param $precision
     * @param $scale
     * @return AbstractNumericPointType|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockAbstractNumericPointType($type, $signed, $precision, $scale)
    {
        $mockAbstractNumericPointType = $this->getMockForAbstractClass(
            AbstractNumericPointType::class,
            [
                $signed,
                $precision,
                $scale
            ]
        );

        $mockAbstractNumericPointType->method('getType')
            ->willReturn($type);

        return $mockAbstractNumericPointType;
    }
}
