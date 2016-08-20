<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\DataType\CharTypeInterface;

abstract class CharTypeTestCase extends DataTypeTestCase
{
    /**
     * @return CharTypeInterface
     */
    abstract protected function getCharType();

    /**
     * @return CharTypeInterface
     */
    abstract protected function createCharType();

    abstract protected function getInitialLength();

    public function testInitialProperties()
    {
        $charType = $this->getCharType();

        $this->assertTrue($charType->hasLength());
        $this->assertSame($this->getInitialLength(), $charType->getLength());

        $this->assertFalse($charType->hasCollation());
        $this->assertNull($charType->getCollation());

        $this->assertTrue($charType->doesAllowDefault());
    }

    public function testSetNewLength()
    {
        $charType = $this->getCharType();
        $charType->setLength(12);

        $this->assertSame(12, $charType->getLength());
    }

    public function testSetCollation()
    {
        $collation = 'utf8mb4_general_ci';
        $charType = $this->getCharType();
        $charType->setCollation($collation);

        $this->assertTrue($charType->hasCollation());
        $this->assertSame($collation, $charType->getCollation());
    }

    public function testCast()
    {
        $charType = $this->getCharType();

        $this->assertSame('123', $charType->cast(123));
    }

    public function DDLProvider()
    {
        $length = $this->getInitialLength();
        $collation = 'utf8mb4_general_ci';
        $charType = $this->createCharType();

        $charTypeCollate = $this->createCharType();
        $charTypeCollate->setCollation($collation);

        return [
            [
                strtoupper($charType->getType()) . "($length)",
                $charType
            ],
            [
                strtoupper($charType->getType()) . "($length) COLLATE '$collation'",
                $charTypeCollate
            ]
        ];
    }
}
