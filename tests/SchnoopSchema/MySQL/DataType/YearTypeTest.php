<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\YearType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;

class YearTypeTest extends SchnoopSchemaTestCase
{
    public function testInitialProperties(): void
    {
        $yearType = new YearType();
        $yearStr = '2016';

        $this->assertSame(DataTypeInterface::TYPE_YEAR, $yearType->getType());
        $this->assertTrue($yearType->doesAllowDefault());
        $this->assertSame((int) $yearStr, $yearType->cast($yearStr));
        $this->assertSame('YEAR', (string) $yearType);
    }
}
