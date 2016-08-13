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

    protected $length = '3';

    public function setUp()
    {
        parent::setUp();

        $this->bitType = new BitType($this->length);
    }

    public function testConstruct()
    {
        $this->assertSame(DataTypeInterface::TYPE_BIT, $this->bitType->getType());
        $this->assertSame((int)$this->length, $this->bitType->getLength());
        $this->assertSame(0, $this->bitType->getMinRange());
        $this->assertSame(pow(2, 3), $this->bitType->getMaxRange());
        $this->assertTrue($this->bitType->doesAllowDefault());
        $this->assertSame("BIT({$this->length})", (string)$this->bitType);
    }

    public function testCast()
    {
        $this->assertSame(123, $this->bitType->cast('123'));
    }
}
