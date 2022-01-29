<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TimeType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\TimeTypeTestCase;

class TimeTypeTest extends TimeTypeTestCase
{
    /**
     * @var TimeType
     */
    protected $timeType;

    public function setUp(): void
    {
        parent::setUp();

        $this->timeType = new TimeType();
    }

    protected function getTimeType()
    {
        return $this->timeType;
    }

    protected function createTimeType()
    {
        return new TimeType();
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_TIME, $this->timeType->getType());
    }
}
