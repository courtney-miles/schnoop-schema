<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractTextType;
use PHPUnit_Framework_MockObject_MockObject;

class AbstractTextTypeTest extends SchnoopTestCase
{
    /**
     * @dataProvider constructedProvider()
     * @param string $type
     * @param int $length
     * @param string $collation
     * @param string $expectedDDL
     */
    public function testConstructed(
        $type,
        $length,
        $collation,
        $expectedDDL
    ) {
        $abstractTextType = $this->createMockAbstractTextType($type, $length, $collation);

        $this->stringTypeAsserts(
            $type,
            $length,
            $collation,
            false,
            $expectedDDL,
            $abstractTextType
        );
    }

    /**
     * @see testConstructed()
     * @return array
     */
    public function constructedProvider()
    {
        $type = 'foo';
        $length = 128;
        $collation = 'utf8_general_ci';

        return [
            [
                $type,
                $length,
                $collation,
                "FOO COLLATE '$collation'"
            ],
            [
                $type,
                $length,
                null,
                "FOO"
            ]
        ];
    }

    /**
     * @param string $type
     * @param int $length
     * @param string $collation
     * @return AbstractTextType|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockAbstractTextType($type, $length, $collation)
    {
        $abstractTextType = $this->getMockForAbstractClass(
            AbstractTextType::class,
            [
                $length,
                $collation
            ]
        );

        $abstractTextType->method('getType')
            ->willReturn($type);

        return $abstractTextType;
    }
}
