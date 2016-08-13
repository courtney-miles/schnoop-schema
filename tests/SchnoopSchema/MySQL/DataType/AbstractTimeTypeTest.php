<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 11/07/16
 * Time: 4:41 PM
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractTimeType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TimeTypeInterface;
use PHPUnit_Framework_MockObject_MockObject;

class AbstractTimeTypeTest extends SchnoopSchemaTestCase
{
    /**
     * @dataProvider abstractTimeTypeProvider
     * @param string $type
     * @param int $precision
     * @param string $expectedDDL
     */
    public function testConstruct(
        $type,
        $precision,
        $expectedDDL
    ) {
        $abstractTimeType = $this->createMockAbstractTimeType($type, $precision);

        $this->timeTypeAsserts(
            $type,
            $precision === null ? 0 : $precision,
            true,
            $expectedDDL,
            $abstractTimeType
        );
    }

    public function testCast()
    {
        /** @var AbstractTimeType|PHPUnit_Framework_MockObject_MockObject $abstractTimeType */
        $abstractTimeType = $abstractTimeType = $this->getMockForAbstractClass(AbstractTimeType::class);
        $time = '11:59:59';

        $this->assertSame($time, $abstractTimeType->cast($time));
    }

    /**
     * @see testConstruct
     */
    public function abstractTimeTypeProvider()
    {
        $precision = 3;

        return [
            [
                'foo',
                null,
                'FOO'
            ],
            [
                'foo',
                $precision,
                "FOO($precision)"
            ]
        ];
    }

    /**
     * @param $type
     * @param null $precision
     * @return AbstractTimeType|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockAbstractTimeType($type, $precision)
    {
        $constructArgs = isset($precision) ? [$precision] : [];

        $abstractTimeType = $this->getMockForAbstractClass(
            AbstractTimeType::class,
            $constructArgs
        );

        $abstractTimeType->method('getType')
            ->willReturn($type);

        return $abstractTimeType;
    }
}
