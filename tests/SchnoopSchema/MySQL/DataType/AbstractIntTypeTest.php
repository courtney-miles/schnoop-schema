<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractIntType;
use PHPUnit_Framework_MockObject_MockObject;

class AbstractIntTypeTest extends SchnoopTestCase
{
    /**
     * @dataProvider constructProvider()
     * @param string $type
     * @param int $displayWidth
     * @param bool $isSigned
     * @param int $minRange
     * @param int $maxRange
     * @param string $expectedDDL
     */
    public function testConstructed(
        $type,
        $displayWidth,
        $isSigned,
        $minRange,
        $maxRange,
        $expectedDDL
    ) {
        $abstractIntType = $this->createMockAbstractIntType(
            $type,
            $displayWidth,
            $isSigned,
            $minRange,
            $maxRange
        );

        $this->intTypeAsserts(
            $type,
            (int)$displayWidth,
            $isSigned,
            $minRange,
            $maxRange,
            true,
            $expectedDDL,
            $abstractIntType
        );
    }

    public function testCast()
    {
        $abstractIntType = $this->createMockAbstractIntType('foo', 3, true, 1, 1);

        $this->assertSame(123, $abstractIntType->cast('123'));
    }

    /**
     * @see testConstructed()
     * @return array
     */
    public function constructProvider()
    {
        return [
            [
                'foo',
                3,
                true,
                -128,
                127,
                'FOO(3)'
            ],
            [
                'foo',
                3,
                false,
                -128,
                127,
                'FOO(3) UNSIGNED'
            ],
            [
                'foo',
                null,
                false,
                -128,
                127,
                'FOO UNSIGNED'
            ]
        ];
    }

    /**
     * @param string $type
     * @param int $displayWidth
     * @param bool $isSigned
     * @param int $minRange
     * @param int $maxRange
     * @return AbstractIntType|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockAbstractIntType(
        $type,
        $displayWidth,
        $isSigned,
        $minRange,
        $maxRange
    ) {
        $abstractIntType = $this->getMockForAbstractClass(
            AbstractIntType::class,
            [
                $displayWidth,
                $isSigned,
                $minRange,
                $maxRange
            ]
        );

        $abstractIntType->method('getType')
            ->willReturn($type);

        return $abstractIntType;
    }
}
