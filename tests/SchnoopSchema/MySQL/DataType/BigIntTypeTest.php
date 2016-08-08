<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\BigIntType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

class BigIntTypeTest extends SchnoopTestCase
{
    /**
     * @dataProvider constructedProvider()
     * @param int $expectedDisplayWidth
     * @param bool $expectedIsSigned
     * @param int $expectedMinRange
     * @param int $expectedMaxRange
     * @param string $expectedDDL
     * @param BigIntType $actualBigInt
     */
    public function testConstructed(
        $expectedDisplayWidth,
        $expectedIsSigned,
        $expectedMinRange,
        $expectedMaxRange,
        $expectedDDL,
        BigIntType $actualBigInt
    ) {
        $this->intTypeAsserts(
            DataTypeInterface::TYPE_BIGINT,
            $expectedDisplayWidth,
            $expectedIsSigned,
            $expectedMinRange,
            $expectedMaxRange,
            true,
            $expectedDDL,
            $actualBigInt
        );
    }

    public function testCast()
    {
        $bigInt = new BigIntType(10, false);

        $this->assertSame(123, $bigInt->cast('123'));
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
                (float)('-' . bcdiv(bcpow('2', '64'), '2')),
                (int)bcsub(bcdiv(bcpow('2', '64'), '2'), '1'),
                "BIGINT($displayWidth)",
                new BigIntType($displayWidth, $signed)
            ],
            [
                $displayWidth,
                $notSigned,
                0,
                (float)bcsub(bcpow('2', '64'), '1'),
                "BIGINT($displayWidth) UNSIGNED",
                new BigIntType($displayWidth, $notSigned)
            ]
        ];
    }
}
