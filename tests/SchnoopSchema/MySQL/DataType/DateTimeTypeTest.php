<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DateTimeType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\TimeTypeTestCase;

class DateTimeTypeTest extends TimeTypeTestCase
{
    /**
     * @var DateTimeType
     */
    protected $dateTimeType;

    public function setUp()
    {
        parent::setUp();

        $this->dateTimeType = new DateTimeType();
    }

    protected function getTimeType()
    {
        return $this->dateTimeType;
    }

    protected function createTimeType()
    {
        return new DateTimeType();
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_DATETIME, $this->dateTimeType->getType());
    }
}
