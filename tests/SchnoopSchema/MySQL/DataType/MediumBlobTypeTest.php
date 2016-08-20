<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\DataTypeTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\MediumBlobType;

class MediumBlobTypeTest extends DataTypeTestCase
{
    /**
     * @var MediumBlobType
     */
    protected $mediumBlobType;

    public function setUp()
    {
        parent::setUp();

        $this->mediumBlobType = new MediumBlobType();
    }

    public function testInitialProperties()
    {
        $this->assertSame(DataTypeInterface::TYPE_MEDIUMBLOB, $this->mediumBlobType->getType());
        $this->assertFalse($this->mediumBlobType->doesAllowDefault());
    }

    public function testCast()
    {
        $this->assertSame('123', $this->mediumBlobType->cast(123));
    }

    /**
     * @see testDDL
     * @return array
     */
    public function DDLProvider()
    {
        $mediumBlobType = new MediumBlobType();

        return [
            [
                'MEDIUMBLOB',
                $mediumBlobType
            ]
        ];
    }
}
