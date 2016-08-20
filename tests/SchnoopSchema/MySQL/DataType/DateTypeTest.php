<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DateType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;

class DateTypeTest extends SchnoopSchemaTestCase
{
    public function testInitialProperties()
    {
        $dateType = new DateType();
        $dateStr = '2016-01-01';

        $this->assertSame(DataTypeInterface::TYPE_DATE, $dateType->getType());
        $this->assertTrue($dateType->doesAllowDefault());
        $this->assertSame($dateStr, $dateType->cast($dateStr));
        $this->assertSame('DATE', (string)$dateType);
    }
}
