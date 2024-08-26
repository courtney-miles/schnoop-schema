<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 28/06/16
 * Time: 8:09 PM.
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractBinaryType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\BinaryTypeInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\BinaryTypeTestCase;

class AbstractBinaryTypeTest extends BinaryTypeTestCase
{
    /**
     * @var AbstractBinaryType
     */
    protected $abstractBinaryType;

    protected $length = '3';

    protected $type = 'foo';

    public function setUp(): void
    {
        parent::setUp();

        $this->abstractBinaryType = $this->createMockAbstractBinaryType($this->type);
    }

    /**
     * @return BinaryTypeInterface
     */
    protected function getBinaryType()
    {
        return $this->abstractBinaryType;
    }

    public function testInitialProperties(): void
    {
        $this->assertFalse($this->abstractBinaryType->hasLength());
        $this->assertNull($this->abstractBinaryType->getLength());
        $this->assertTrue($this->abstractBinaryType->doesAllowDefault());
    }

    public function testCast(): void
    {
        $this->assertSame('123', $this->abstractBinaryType->cast(123));
    }

    /**
     * @see testDDL
     *
     * @return array
     */
    public function DDLProvider()
    {
        $abstractBinaryType = $this->createMockAbstractBinaryType('foo');

        $abstractBinaryTypeExtra = $this->createMockAbstractBinaryType('foo');
        $abstractBinaryTypeExtra->setLength(3);

        return [
            [
                'FOO',
                $abstractBinaryType,
            ],
            [
                'FOO(3)',
                $abstractBinaryTypeExtra,
            ],
        ];
    }

    /**
     * @return AbstractBinaryType|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockAbstractBinaryType($type)
    {
        $abstractBinaryType = $this->getMockForAbstractClass(
            AbstractBinaryType::class
        );
        $abstractBinaryType->method('getType')
            ->willReturn($type);

        return $abstractBinaryType;
    }
}
