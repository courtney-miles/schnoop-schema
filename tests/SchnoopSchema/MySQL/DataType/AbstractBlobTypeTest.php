<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\DataTypeTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractBlobType;

class AbstractBlobTypeTest extends DataTypeTestCase
{
    /**
     * @var AbstractBlobType
     */
    protected $abstractBlobType;

    protected $length = 123;

    protected $type = 'foo';

    public function setUp(): void
    {
        parent::setUp();

        $this->abstractBlobType = $this->createMockAbstractBlobType($this->type);
    }

    public function testInitialProperties()
    {
        $this->assertFalse($this->abstractBlobType->doesAllowDefault());
    }

    public function testCast()
    {
        $this->assertSame('123', $this->abstractBlobType->cast(123));
    }

    /**
     * @see testDDL
     * @return array
     */
    public function DDLProvider()
    {
        return [
            [
                'FOO',
                $this->createMockAbstractBlobType('foo')
            ]
        ];
    }

    /**
     * @param $type
     * @return AbstractBlobType|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockAbstractBlobType($type)
    {
        $abstractBlobType = $this->getMockForAbstractClass(
            AbstractBlobType::class
        );
        $abstractBlobType->method('getType')->willReturn($type);

        return $abstractBlobType;
    }
}
