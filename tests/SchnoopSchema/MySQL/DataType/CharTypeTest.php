<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\CharType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\CharTypeTestCase;

class CharTypeTest extends CharTypeTestCase
{
    /**
     * @var CharType
     */
    protected $charType;
    protected $length = 1;

    public function setUp(): void
    {
        parent::setUp();

        $this->charType = new CharType();
    }

    protected function getCharType()
    {
        return $this->charType;
    }

    protected function createCharType()
    {
        return new CharType();
    }

    protected function getInitialLength()
    {
        return $this->length;
    }

    public function testInitialProperties(): void
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_CHAR, $this->charType->getType());
    }
}
