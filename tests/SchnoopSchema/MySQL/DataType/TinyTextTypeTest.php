<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\TextTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TinyTextType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\TextTypeTestCase;

class TinyTextTypeTest extends TextTypeTestCase
{
    /**
     * @var TinyTextType
     */
    protected $tinyTextType;

    public function setUp()
    {
        parent::setUp();

        $this->tinyTextType = new TinyTextType();
    }

    /**
     * @return TextTypeInterface
     */
    protected function getTextType()
    {
        return $this->tinyTextType;
    }

    /**
     * @return TextTypeInterface
     */
    protected function createTextType()
    {
        return new TinyTextType();
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_TINYTEXT, $this->tinyTextType->getType());
    }
}
