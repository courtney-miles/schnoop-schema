<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\MediumBlobType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\DataTypeTestCase;

class MediumBlobTypeTest extends DataTypeTestCase
{
    /**
     * @var MediumBlobType
     */
    protected $mediumBlobType;

    public function setUp(): void
    {
        parent::setUp();

        $this->mediumBlobType = new MediumBlobType();
    }

    public function testInitialProperties(): void
    {
        $this->assertSame(DataTypeInterface::TYPE_MEDIUMBLOB, $this->mediumBlobType->getType());
        $this->assertFalse($this->mediumBlobType->doesAllowDefault());
    }

    public function testCast(): void
    {
        $this->assertSame('123', $this->mediumBlobType->cast(123));
    }

    /**
     * @see testDDL
     *
     * @return array
     */
    public function DDLProvider()
    {
        $mediumBlobType = new MediumBlobType();

        return [
            [
                'MEDIUMBLOB',
                $mediumBlobType,
            ],
        ];
    }
}
