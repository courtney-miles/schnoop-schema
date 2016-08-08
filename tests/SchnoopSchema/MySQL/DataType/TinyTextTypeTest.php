<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TinyTextType;

class TinyTextTypeTest extends SchnoopTestCase
{
    /**
     * @dataProvider constructedProvider()
     * @param int $expectedLength
     * @param string|null $expectedCollation
     * @param string $expectedDDL
     * @param TinyTextType $actualLongTextType
     */
    public function testConstructed(
        $expectedLength,
        $expectedCollation,
        $expectedDDL,
        TinyTextType $actualLongTextType
    ) {
        $this->stringTypeAsserts(
            DataTypeInterface::TYPE_TINYTEXT,
            $expectedLength,
            $expectedCollation,
            false,
            $expectedDDL,
            $actualLongTextType
        );
    }

    public function testCast()
    {
        $longTextType = new TinyTextType();
        $this->assertSame('123', $longTextType->cast(123));
    }

    /**
     * @see testConstructed()
     * @return array
     */
    public function constructedProvider()
    {
        $length = pow(2, 8) -1;
        $collation = 'utf8_general_ci';

        return [
            [
                $length,
                $collation,
                "TINYTEXT COLLATE '$collation'",
                new TinyTextType($collation)
            ],
            [
                $length,
                null,
                'TINYTEXT',
                new TinyTextType()
            ]
        ];
    }
}
