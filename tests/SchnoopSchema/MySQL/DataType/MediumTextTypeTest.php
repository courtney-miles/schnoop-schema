<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\MediumTextType;

class MediumTextTypeTest extends SchnoopTestCase
{
    /**
     * @dataProvider constructedProvider()
     * @param int $expectedLength
     * @param string|null $expectedCollation
     * @param string $expectedDDL
     * @param MediumTextType $actualMediumTextType
     */
    public function testConstructed(
        $expectedLength,
        $expectedCollation,
        $expectedDDL,
        MediumTextType $actualMediumTextType
    ) {
        $this->stringTypeAsserts(
            DataTypeInterface::TYPE_MEDIUMTEXT,
            $expectedLength,
            $expectedCollation,
            false,
            $expectedDDL,
            $actualMediumTextType
        );
    }

    public function testCast()
    {
        $mediumTextType = new MediumTextType();
        $this->assertSame('123', $mediumTextType->cast(123));
    }

    /**
     * @see testConstructed()
     * @return array
     */
    public function constructedProvider()
    {
        $length = pow(2, 24) -1;
        $collation = 'utf8_general_ci';

        return [
            [
                $length,
                $collation,
                "MEDIUMTEXT COLLATE '$collation'",
                new MediumTextType($collation)
            ],
            [
                $length,
                null,
                'MEDIUMTEXT',
                new MediumTextType()
            ]
        ];
    }
}
