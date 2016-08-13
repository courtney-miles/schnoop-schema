<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 26/06/16
 * Time: 5:58 PM
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\BinaryType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

class BinaryTypeTest extends SchnoopSchemaTestCase
{
    /**
     * @var BinaryType
     */
    protected $binaryType;

    protected $length = 3;

    public function setUp()
    {
        parent::setUp();

        $this->binaryType = new BinaryType($this->length);
    }

    public function testConstruct()
    {
        $this->binaryTypeAsserts(
            DataTypeInterface::TYPE_BINARY,
            $this->length,
            true,
            'BINARY(3)',
            $this->binaryType
        );
    }

    public function testCast()
    {
        $this->assertSame('123', $this->binaryType->cast(123));
    }
}
