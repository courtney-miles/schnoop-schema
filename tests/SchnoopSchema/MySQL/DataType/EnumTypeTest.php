<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\EnumType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\OptionsTypeTestCase;

class EnumTypeTest extends OptionsTypeTestCase
{
    /**
     * @var EnumType
     */
    protected $enumType;

    public function setUp(): void
    {
        parent::setUp();

        $this->enumType = new EnumType();
    }

    public function getOptionsType()
    {
        return $this->enumType;
    }

    public function createOptionsType()
    {
        return new EnumType();
    }

    public function testInitialProperties(): void
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_ENUM, $this->enumType->getType());
    }
}
