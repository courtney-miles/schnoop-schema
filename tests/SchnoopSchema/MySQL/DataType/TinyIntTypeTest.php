<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TinyIntType;

class TinyIntTypeTest extends SchnoopTestCase
{
    /**
     * @dataProvider constructedProvider()
     * @param int $expectedDisplayWidth
     * @param bool $expectedIsSigned
     * @param int $expectedMinRange
     * @param int $expectedMaxRange
     * @param string $expectedDDL
     * @param TinyIntType $actualTinyIntType
     */
    public function testConstructed(
        $expectedDisplayWidth,
        $expectedIsSigned,
        $expectedMinRange,
        $expectedMaxRange,
        $expectedDDL,
        TinyIntType $actualTinyIntType
    ) {
        $this->intTypeAsserts(
            DataTypeInterface::TYPE_TINYINT,
            $expectedDisplayWidth,
            $expectedIsSigned,
            $expectedMinRange,
            $expectedMaxRange,
            true,
            $expectedDDL,
            $actualTinyIntType
        );
    }

    public function testCast()
    {
        $tinyIntType = new TinyIntType(2, true);
        $this->assertSame(123, $tinyIntType->cast('123'));
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
                -pow(2, 8)/2,
                pow(2, 8)/2-1,
                "TINYINT($displayWidth)",
                new TinyIntType($displayWidth, $signed)
            ],
            [
                $displayWidth,
                $notSigned,
                0,
                pow(2, 8)-1,
                "TINYINT($displayWidth) UNSIGNED",
                new TinyIntType($displayWidth, $notSigned)
            ]
        ];
    }
}
