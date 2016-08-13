<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 26/06/16
 * Time: 6:19 PM
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TinyBlobType;

class TinyBlobTypeTest extends SchnoopSchemaTestCase
{
    /**
     * @var TinyBlobType
     */
    protected $tinyBlobType;

    public function setUp()
    {
        parent::setUp();

        $this->tinyBlobType = new TinyBlobType();
    }

    public function testConstruct()
    {
        $this->binaryTypeAsserts(
            DataTypeInterface::TYPE_TINYBLOB,
            pow(2, 8)-1,
            false,
            'TINYBLOB',
            $this->tinyBlobType
        );
    }

    public function testCast()
    {
        $this->assertSame('123', $this->tinyBlobType->cast(123));
    }
}
