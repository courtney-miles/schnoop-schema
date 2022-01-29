<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractOptionsType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\OptionsTypeTestCase;

class AbstractOptionsTypeTest extends OptionsTypeTestCase
{
    /**
     * @var AbstractOptionsType
     */
    protected $abstractOptionsType;

    protected $type = 'foo';

    public function setUp(): void
    {
        parent::setUp();

        $this->abstractOptionsType = $this->createOptionsType();
    }

    public function getOptionsType()
    {
        return $this->abstractOptionsType;
    }

    public function createOptionsType()
    {
        return $this->createAbstractOptionsType($this->type);
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame($this->type, $this->abstractOptionsType->getType());
    }

    protected function createAbstractOptionsType($type)
    {
        $abstractOptionsType = $this->getMockForAbstractClass(AbstractOptionsType::class);
        $abstractOptionsType->method('getType')->willReturn($type);

        return $abstractOptionsType;
    }
}
