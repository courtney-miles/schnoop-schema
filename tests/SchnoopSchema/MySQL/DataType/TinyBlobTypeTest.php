<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 26/06/16
 * Time: 6:19 PM
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\DataTypeTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TinyBlobType;

class TinyBlobTypeTest extends DataTypeTestCase
{
    /**
     * @var TinyBlobType
     */
    protected $tinyBlobType;

    public function setUp(): void
    {
        parent::setUp();

        $this->tinyBlobType = new TinyBlobType();
    }

    public function testInitialProperties()
    {
        $this->assertSame(DataTypeInterface::TYPE_TINYBLOB, $this->tinyBlobType->getType());
        $this->assertFalse($this->tinyBlobType->doesAllowDefault());
    }

    public function testCast()
    {
        $this->assertSame('123', $this->tinyBlobType->cast(123));
    }

    /**
     * @see testDDL
     * @return array
     */
    public function DDLProvider()
    {
        $tinyBlobType = new TinyBlobType();

        return [
            [
                'TINYBLOB',
                $tinyBlobType
            ]
        ];
    }
}
