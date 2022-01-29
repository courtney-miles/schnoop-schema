<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TextType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TextTypeInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\TextTypeTestCase;

class TextTypeTest extends TextTypeTestCase
{
    /**
     * @var TextType
     */
    protected $textType;

    public function setUp(): void
    {
        parent::setUp();

        $this->textType = new TextType();
    }

    /**
     * @return TextTypeInterface
     */
    protected function getTextType()
    {
        return $this->textType;
    }

    /**
     * @return TextTypeInterface
     */
    protected function createTextType()
    {
        return new TextType();
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_TEXT, $this->textType->getType());
        $this->assertSame(65535, $this->textType->getLength());
    }
}
