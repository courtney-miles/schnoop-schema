<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TimeType;

class TimeTypeTest extends SchnoopSchemaTestCase
{
    /**
     * @dataProvider timeTypeProvider
     * @param int $expectedPrecision
     * @param string $expectedDDL
     * @param TimeType $actualTimeType
     */
    public function testConstruct(
        $expectedPrecision,
        $expectedDDL,
        TimeType $actualTimeType
    ) {
        $this->timeTypeAsserts(
            DataTypeInterface::TYPE_TIME,
            $expectedPrecision,
            true,
            $expectedDDL,
            $actualTimeType
        );
    }

    public function testCast()
    {
        $time = '11:59';
        $timeType = new TimeType();

        $this->assertSame($time, $timeType->cast($time));
    }

    /**
     * @see testConstruct
     */
    public function timeTypeProvider()
    {
        $precision = 3;

        return [
            [
                0,
                'TIME',
                new TimeType()
            ],
            [
                $precision,
                "TIME($precision)",
                new TimeType($precision)
            ]
        ];
    }
}
