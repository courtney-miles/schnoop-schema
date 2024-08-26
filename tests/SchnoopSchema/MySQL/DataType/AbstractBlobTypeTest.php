<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractBlobType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\DataTypeTestCase;

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

    public function testInitialProperties(): void
    {
        $this->assertFalse($this->abstractBlobType->doesAllowDefault());
    }

    public function testCast(): void
    {
        $this->assertSame('123', $this->abstractBlobType->cast(123));
    }

    /**
     * @see testDDL
     *
     * @return array
     */
    public function DDLProvider()
    {
        return [
            [
                'FOO',
                $this->createMockAbstractBlobType('foo'),
            ],
        ];
    }

    /**
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
