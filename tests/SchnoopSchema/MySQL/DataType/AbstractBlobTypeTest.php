<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractBlobType;

class AbstractBlobTypeTest extends SchnoopSchemaTestCase
{
    /**
     * @var AbstractBlobType
     */
    protected $abstractBlobType;

    protected $length = 123;

    protected $type = 'foo';

    public function setUp()
    {
        parent::setUp();

        $this->abstractBlobType = $this->getMockForAbstractClass(
            AbstractBlobType::class,
            [$this->length]
        );

        $this->abstractBlobType->method('getType')
            ->willReturn($this->type);
    }

    public function testConstructed()
    {
        $this->binaryTypeAsserts(
            $this->type,
            $this->length,
            false,
            strtoupper($this->type),
            $this->abstractBlobType
        );
    }
}
