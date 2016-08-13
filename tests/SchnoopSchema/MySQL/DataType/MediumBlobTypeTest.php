<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\MediumBlobType;

class MediumBlobTypeTest extends SchnoopSchemaTestCase
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

    public function testConstruct()
    {
        $this->binaryTypeAsserts(
            DataTypeInterface::TYPE_MEDIUMBLOB,
            pow(2, 24)-1,
            false,
            'MEDIUMBLOB',
            $this->mediumBlobType
        );
    }

    public function testCast()
    {
        $this->assertSame('123', $this->mediumBlobType->cast(123));
    }
}
