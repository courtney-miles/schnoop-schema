<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\BinaryTypeTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\BinaryType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

class BinaryTypeTest extends BinaryTypeTestCase
{
    /**
     * @var BinaryType
     */
    protected $binaryType;

    public function setUp()
    {
        parent::setUp();

        $this->binaryType = new BinaryType();
    }

    protected function getBinaryType()
    {
        return $this->binaryType;
    }

    public function testInitialProperties()
    {
        $this->assertSame(DataTypeInterface::TYPE_BINARY, $this->binaryType->getType());
        $this->assertFalse($this->binaryType->hasLength());
        $this->assertNull($this->binaryType->getLength());
        $this->assertTrue($this->binaryType->doesAllowDefault());
    }

    /**
     * @see testDDL
     * @return array
     */
    public function DDLProvider()
    {
        $binaryType = new BinaryType();

        $binaryTypeExtra = new BinaryType();
        $binaryTypeExtra->setLength(3);

        return [
            [
                'BINARY',
                $binaryType
            ],
            [
                'BINARY(3)',
                $binaryTypeExtra
            ]
        ];
    }
}
