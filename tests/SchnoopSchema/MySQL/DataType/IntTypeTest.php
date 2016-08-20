<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IntTypeTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\IntType;

class IntTypeTest extends IntTypeTestCase
{
    /**
     * @var IntType
     */
    protected $intType;

    public function setUp()
    {
        parent::setUp();

        $this->intType = new IntType();
    }

    protected function getIntType()
    {
        return $this->intType;
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_INT, $this->intType->getType());
        $this->assertSame(IntType::MIN_SIGNED, $this->intType->getMinRange());
        $this->assertSame(IntType::MAX_SIGNED, $this->intType->getMaxRange());
    }

    public function testSetUnsigned()
    {
        $this->intType->setSigned(false);

        $this->assertFalse($this->intType->isSigned());
        $this->assertSame(IntType::MIN_UNSIGNED, $this->intType->getMinRange());
        $this->assertSame(IntType::MAX_UNSIGNED, $this->intType->getMaxRange());
    }

    /**
     * @see testDDL
     * @return array
     */
    public function DDLProvider()
    {
        $intTypeDefault = new IntType();

        $intTypeExtra = new IntType();
        $intTypeExtra->setDisplayWidth(3);
        $intTypeExtra->setSigned(false);

        return [
            [
                'INT',
                $intTypeDefault
            ],
            [
                'INT(3) UNSIGNED',
                $intTypeExtra
            ]
        ];
    }
}
