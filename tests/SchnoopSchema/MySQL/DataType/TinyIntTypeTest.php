<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IntTypeTestCase;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TinyIntType;

class TinyIntTypeTest extends IntTypeTestCase
{
    /**
     * @var TinyIntType
     */
    protected $tinyIntType;

    public function setUp()
    {
        parent::setUp();

        $this->tinyIntType = new TinyIntType();
    }

    protected function getIntType()
    {
        return $this->tinyIntType;
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_TINYINT, $this->tinyIntType->getType());
        $this->assertSame(TinyIntType::MIN_SIGNED, $this->tinyIntType->getMinRange());
        $this->assertSame(TinyIntType::MAX_SIGNED, $this->tinyIntType->getMaxRange());
    }

    public function testSetUnsigned()
    {
        $this->tinyIntType->setSigned(false);

        $this->assertFalse($this->tinyIntType->isSigned());
        $this->assertSame(TinyIntType::MIN_UNSIGNED, $this->tinyIntType->getMinRange());
        $this->assertSame(TinyIntType::MAX_UNSIGNED, $this->tinyIntType->getMaxRange());
    }

    /**
     * @see testDDL
     * @return array
     */
    public function DDLProvider()
    {
        $tinyIntTypeDefault = new TinyIntType();

        $tinyIntTypeExtra = new TinyIntType();
        $tinyIntTypeExtra->setDisplayWidth(3);
        $tinyIntTypeExtra->setSigned(false);

        return [
            [
                'TINYINT',
                $tinyIntTypeDefault
            ],
            [
                'TINYINT(3) UNSIGNED',
                $tinyIntTypeExtra
            ]
        ];
    }
}
