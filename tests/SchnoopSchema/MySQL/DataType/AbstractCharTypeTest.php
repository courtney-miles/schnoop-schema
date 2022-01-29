<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractCharType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\CharTypeTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class AbstractCharTypeTest extends CharTypeTestCase
{
    /**
     * @var AbstractCharType
     */
    protected $abstractCharType;

    protected $type = 'foo';

    protected $length = 6;

    public function setUp(): void
    {
        parent::setUp();

        $this->abstractCharType = $this->createMockAbstractCharType($this->type);
    }

    protected function getCharType()
    {
        return $this->abstractCharType;
    }

    protected function createCharType()
    {
        return $this->createMockAbstractCharType($this->type);
    }

    protected function getInitialLength()
    {
        return $this->length;
    }

    public function testInitialProperties(): void
    {
        parent::testInitialProperties();
        $this->assertSame($this->type, $this->abstractCharType->getType());
    }

    /**
     * @param $type
     *
     * @return AbstractCharType|MockObject
     */
    protected function createMockAbstractCharType($type)
    {
        $abstractStringType = $this->getMockForAbstractClass(
            AbstractCharType::class,
            [$this->length]
        );

        $abstractStringType->method('getType')
            ->willReturn($type);

        return $abstractStringType;
    }
}
