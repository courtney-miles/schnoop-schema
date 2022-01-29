<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractBlobType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractTextType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\TextTypeTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class AbstractTextTypeTest extends TextTypeTestCase
{
    /**
     * @var AbstractBlobType
     */
    protected $abstractTextType;

    protected $type = 'foo';

    public function setUp(): void
    {
        parent::setUp();

        $this->abstractTextType = $this->createMockAbstractTextType($this->type);
    }

    protected function getTextType()
    {
        return $this->abstractTextType;
    }

    protected function createTextType()
    {
        return $this->createMockAbstractTextType($this->type);
    }

    public function testInitialProperties(): void
    {
        parent::testInitialProperties();
        $this->assertSame($this->type, $this->abstractTextType->getType());
    }

    /**
     * @param string $type
     *
     * @return AbstractTextType|MockObject
     */
    protected function createMockAbstractTextType($type)
    {
        $abstractTextType = $this->getMockForAbstractClass(AbstractTextType::class);

        $abstractTextType->method('getType')
            ->willReturn($type);

        return $abstractTextType;
    }
}
