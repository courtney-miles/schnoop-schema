<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\BinaryTypeTestCase;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\VarBinaryType;

class VarBinaryTypeTest extends BinaryTypeTestCase
{
    /**
     * @var VarBinaryType
     */
    protected $varBinaryType;

    protected $length = 5;

    public function setUp()
    {
        parent::setUp();

        $this->varBinaryType = new VarBinaryType($this->length);
    }

    protected function getBinaryType()
    {
        return $this->varBinaryType;
    }

    public function testInitialProperties()
    {
        $this->assertSame(DataTypeInterface::TYPE_VARBINARY, $this->varBinaryType->getType());
        $this->assertTrue($this->varBinaryType->hasLength());
        $this->assertSame($this->length, $this->varBinaryType->getLength());
        $this->assertTrue($this->varBinaryType->doesAllowDefault());
    }

    /**
     * @see testDDL
     * @return array
     */
    public function DDLProvider()
    {
        $binaryType = new VarBinaryType($this->length);

        return [
            [
                'VARBINARY(5)',
                $binaryType
            ],
        ];
    }
}
