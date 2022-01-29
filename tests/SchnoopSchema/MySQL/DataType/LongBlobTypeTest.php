<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\DataTypeTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\LongBlobType;

class LongBlobTypeTest extends DataTypeTestCase
{
    /**
     * @var LongBlobType
     */
    protected $longBlobType;

    public function setUp(): void
    {
        parent::setUp();

        $this->longBlobType = new LongBlobType();
    }

    public function testInitialProperties()
    {
        $this->assertSame(DataTypeInterface::TYPE_LONGBLOB, $this->longBlobType->getType());
        $this->assertFalse($this->longBlobType->doesAllowDefault());
    }

    public function testCast()
    {
        $this->assertSame('123', $this->longBlobType->cast(123));
    }

    public function DDLProvider()
    {
        $longBlobType = new LongBlobType();

        return [
            [
                'LONGBLOB',
                $longBlobType
            ]
        ];
    }
}
