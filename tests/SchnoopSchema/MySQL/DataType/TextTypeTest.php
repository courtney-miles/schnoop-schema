<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TextType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TextTypeInterface;

class TextTypeTest extends SchnoopSchemaTestCase
{
    /**
     * @dataProvider constructedProvider()
     * @param int $expectedLength
     * @param string|null $expectedCollation
     * @param string $expectedDDL
     * @param TextType $actualLongTextType
     */
    public function testConstructed(
        $expectedLength,
        $expectedCollation,
        $expectedDDL,
        TextType $actualLongTextType
    ) {
        $this->stringTypeAsserts(
            DataTypeInterface::TYPE_TEXT,
            $expectedLength,
            $expectedCollation,
            false,
            $expectedDDL,
            $actualLongTextType
        );
    }

    public function testCast()
    {
        $longTextType = new TextType();
        $this->assertSame('123', $longTextType->cast(123));
    }

    /**
     * @see testConstructed()
     * @return array
     */
    public function constructedProvider()
    {
        $length = pow(2, 16) -1;
        $collation = 'utf8_general_ci';

        return [
            [
                $length,
                $collation,
                "TEXT COLLATE '$collation'",
                new TextType($collation)
            ],
            [
                $length,
                null,
                'TEXT',
                new TextType()
            ]
        ];
    }
}
