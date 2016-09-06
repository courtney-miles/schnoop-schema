<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\TextTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\LongTextType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\TextTypeTestCase;

class LongTextTypeTest extends TextTypeTestCase
{
    /**
     * @var LongTextType
     */
    protected $longTextType;

    public function setUp()
    {
        parent::setUp();

        $this->longTextType = new LongTextType();
    }

    /**
     * @return TextTypeInterface
     */
    protected function getTextType()
    {
        return $this->longTextType;
    }

    /**
     * @return TextTypeInterface
     */
    protected function createTextType()
    {
        return new LongTextType();
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_LONGTEXT, $this->longTextType->getType());
        $this->assertSame(4294967295, $this->longTextType->getLength());
    }
}
