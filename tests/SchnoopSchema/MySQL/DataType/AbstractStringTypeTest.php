<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractStringType;
use PHPUnit_Framework_MockObject_MockObject;

class AbstractStringTypeTest extends SchnoopTestCase
{
    /**
     * @dataProvider constructedProvider()
     * @param string $type
     * @param int $length
     * @param string $collation
     * @param bool $doesAllowDefault
     * @param string $expectedDDL
     */
    public function testConstructed(
        $type,
        $length,
        $collation,
        $doesAllowDefault,
        $expectedDDL
    ) {
        $abstractStringType = $this->createMockAbstractStringType($type, $length, $collation, $doesAllowDefault);

        $this->stringTypeAsserts(
            $type,
            $length,
            $collation,
            $doesAllowDefault,
            $expectedDDL,
            $abstractStringType
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
        $allowDefault = true;

        return [
            [
                $type,
                $length,
                $collation,
                $allowDefault,
                "FOO($length) COLLATE '$collation'"
            ],
            [
                $type,
                $length,
                null,
                $allowDefault,
                "FOO($length)"
            ]
        ];
    }

    /**
     * @param $type
     * @param $length
     * @param $collation
     * @param $doesAllowDefault
     * @return AbstractStringType|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockAbstractStringType($type, $length, $collation, $doesAllowDefault)
    {
        $abstractStringType = $this->getMockForAbstractClass(
            AbstractStringType::class,
            [
                $length,
                $collation
            ]
        );

        $abstractStringType->method('getType')
            ->willReturn($type);

        $abstractStringType->method('doesAllowDefault')
            ->willReturn($doesAllowDefault);

        return $abstractStringType;
    }
}
