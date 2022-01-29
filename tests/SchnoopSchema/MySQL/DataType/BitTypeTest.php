<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 28/06/16
 * Time: 9:46 PM
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\BitType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

class BitTypeTest extends SchnoopSchemaTestCase
{
    /**
     * @var BitType
     */
    protected $bitType;

    public function setUp(): void
    {
        parent::setUp();

        $this->bitType = new BitType();
    }

    public function testInitialProperties()
    {
        $this->assertSame(DataTypeInterface::TYPE_BIT, $this->bitType->getType());
        $this->assertTrue($this->bitType->hasLength());
        $this->assertSame(1, $this->bitType->getLength());
        $this->assertSame(0, $this->bitType->getMinRange());
        $this->assertSame(1, $this->bitType->getMaxRange());
        $this->assertTrue($this->bitType->doesAllowDefault());
        $this->assertSame("BIT(1)", (string)$this->bitType);
    }

    public function testSetLength()
    {
        $length = 4;
        $this->bitType->setLength($length);

        $this->assertSame($length, $this->bitType->getLength());
        $this->assertSame(0, $this->bitType->getMinRange());
        $this->assertSame(15, $this->bitType->getMaxRange());
    }

    public function testCast()
    {
        $this->assertSame(123, $this->bitType->cast('123'));
    }
}
