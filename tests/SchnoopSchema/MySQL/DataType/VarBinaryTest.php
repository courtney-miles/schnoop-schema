<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 26/06/16
 * Time: 6:22 PM
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\VarBinaryType;

class VarBinaryTest extends SchnoopSchemaTestCase
{
    /**
     * @var VarBinaryType
     */
    protected $varBinaryType;

    protected $length = 3;

    public function setUp()
    {
        parent::setUp();

        $this->varBinaryType = new VarBinaryType($this->length);
    }

    public function testConstruct()
    {
        $this->binaryTypeAsserts(
            DataTypeInterface::TYPE_VARBINARY,
            $this->length,
            true,
            'VARBINARY(' . $this->length . ')',
            $this->varBinaryType
        );
    }

    public function testCast()
    {
        $this->assertSame('123', $this->varBinaryType->cast(123));
    }
}
