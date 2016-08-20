<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\DataType\TimeTypeInterface;

abstract class TimeTypeTestCase extends DataTypeTestCase
{
    /**
     * @return TimeTypeInterface
     */
    abstract protected function getTimeType();

    /**
     * @return TimeTypeInterface
     */
    abstract protected function createTimeType();

    public function testInitialProperties()
    {
        $timeType = $this->getTimeType();

        $this->assertFalse($timeType->hasPrecision());
        $this->assertSame(0, $timeType->getPrecision());
        $this->assertTrue($timeType->doesAllowDefault());
    }

    public function testSetPrecision()
    {
        $precision = 2;
        $timeType = $this->getTimeType();
        $timeType->setPrecision($precision);

        $this->assertTrue($timeType->hasPrecision());
        $this->assertSame($precision, $timeType->getPrecision());
    }

    public function testCast()
    {
        $timeType = $this->getTimeType();

        $this->assertSame(123, $timeType->cast(123));
        $this->assertSame('123', $timeType->cast('123'));
    }

    public function DDLProvider()
    {
        $precision = 2;
        $timeType = $this->createTimeType();
        $timeTypePrecision = $this->createTimeType();
        $timeTypePrecision->setPrecision($precision);

        return [
            [
                strtoupper($timeType->getType()),
                $timeType
            ],
            [
                strtoupper($timeType->getType()) . "($precision)",
                $timeTypePrecision
            ]
        ];
    }
}
