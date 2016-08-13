<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\SmallIntType;

class SmallIntTypeTest extends SchnoopSchemaTestCase
{
    /**
     * @dataProvider constructedProvider()
     * @param int $expectedDisplayWidth
     * @param bool $expectedIsSigned
     * @param int $expectedMinRange
     * @param int $expectedMaxRange
     * @param string $expectedDDL
     * @param SmallIntType $actualSmallIntType
     */
    public function testConstructed(
        $expectedDisplayWidth,
        $expectedIsSigned,
        $expectedMinRange,
        $expectedMaxRange,
        $expectedDDL,
        SmallIntType $actualSmallIntType
    ) {
        $this->intTypeAsserts(
            DataTypeInterface::TYPE_SMALLINT,
            $expectedDisplayWidth,
            $expectedIsSigned,
            $expectedMinRange,
            $expectedMaxRange,
            true,
            $expectedDDL,
            $actualSmallIntType
        );
    }

    public function testCast()
    {
        $smallIntType = new SmallIntType(4, true);
        $this->assertSame(123, $smallIntType->cast('123'));
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
                -pow(2, 16)/2,
                pow(2, 16)/2-1,
                "SMALLINT($displayWidth)",
                new SmallIntType($displayWidth, $signed)
            ],
            [
                $displayWidth,
                $notSigned,
                0,
                pow(2, 16)-1,
                "SMALLINT($displayWidth) UNSIGNED",
                new SmallIntType($displayWidth, $notSigned)
            ]
        ];
    }
}
