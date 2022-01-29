<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\BlobType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\DataTypeTestCase;

class BlobTypeTest extends DataTypeTestCase
{
    /**
     * @var BlobType
     */
    protected $blobType;

    public function setUp(): void
    {
        parent::setUp();

        $this->blobType = new BlobType();
    }

    public function testInitialProperties(): void
    {
        $this->assertSame(DataTypeInterface::TYPE_BLOB, $this->blobType->getType());
        $this->assertFalse($this->blobType->doesAllowDefault());
    }

    public function testCast(): void
    {
        $this->assertSame('123', $this->blobType->cast(123));
    }

    public function DDLProvider()
    {
        $blobType = new BlobType();

        return [
            [
                'BLOB',
                $blobType,
            ],
        ];
    }
}
