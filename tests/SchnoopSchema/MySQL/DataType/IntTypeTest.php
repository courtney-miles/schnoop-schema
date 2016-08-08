<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\IntType;

class IntTypeTest extends SchnoopTestCase
{
    /**
     * @dataProvider constructedProvider()
     * @param int $expectedDisplayWidth
     * @param bool $expectedIsSigned
     * @param int $expectedMinRange
     * @param int $expectedMaxRange
     * @param string $expectedDDL
     * @param IntType $actualIntType
     */
    public function testConstructed(
        $expectedDisplayWidth,
        $expectedIsSigned,
        $expectedMinRange,
        $expectedMaxRange,
        $expectedDDL,
        IntType $actualIntType
    ) {
        $this->intTypeAsserts(
            DataTypeInterface::TYPE_INT,
            $expectedDisplayWidth,
            $expectedIsSigned,
            $expectedMinRange,
            $expectedMaxRange,
            true,
            $expectedDDL,
            $actualIntType
        );
    }

    public function testCast()
    {
        $intType = new IntType(10, true);
        $this->assertSame(123, $intType->cast('123'));
    }

    /**
     * @see testConstructed()
     * @return array
     */
    public function constructedProvider()
    {
        $displayWidth = 10;
        $signed = true;
        $notSigned = false;

        return [
            [
                $displayWidth,
                $signed,
                -pow(2, 32)/2,
                pow(2, 32)/2-1,
                "INT($displayWidth)",
                new IntType($displayWidth, $signed)
            ],
            [
                $displayWidth,
                $notSigned,
                0,
                pow(2, 32)-1,
                "INT($displayWidth) UNSIGNED",
                new IntType($displayWidth, $notSigned)
            ]
        ];
    }
}
