<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TimestampType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\TimeTypeTestCase;

class TimestampTypeTest extends TimeTypeTestCase
{
    /**
     * @var TimestampType
     */
    protected $timestampType;

    public function setUp(): void
    {
        parent::setUp();

        $this->timestampType = new TimestampType();
    }

    protected function getTimeType()
    {
        return $this->timestampType;
    }

    protected function createTimeType()
    {
        return new TimestampType();
    }

    public function testInitialProperties(): void
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_TIMESTAMP, $this->timestampType->getType());
    }
}
