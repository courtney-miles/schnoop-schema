<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\LongBlobType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\DataTypeTestCase;

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

    public function testInitialProperties(): void
    {
        $this->assertSame(DataTypeInterface::TYPE_LONGBLOB, $this->longBlobType->getType());
        $this->assertFalse($this->longBlobType->doesAllowDefault());
    }

    public function testCast(): void
    {
        $this->assertSame('123', $this->longBlobType->cast(123));
    }

    public function DDLProvider()
    {
        $longBlobType = new LongBlobType();

        return [
            [
                'LONGBLOB',
                $longBlobType,
            ],
        ];
    }
}
