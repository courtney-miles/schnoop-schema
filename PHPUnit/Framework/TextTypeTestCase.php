<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\DataType\TextTypeInterface;

abstract class TextTypeTestCase extends DataTypeTestCase
{
    /**
     * @return TextTypeInterface
     */
    abstract protected function getTextType();

    /**
     * @return TextTypeInterface
     */
    abstract protected function createTextType();

    public function testInitialProperties()
    {
        $textType = $this->getTextType();

        $this->assertFalse($textType->hasCollation());
        $this->assertNull($textType->getCollation());

        $this->assertFalse($textType->doesAllowDefault());
    }

    public function testSetCollation()
    {
        $collation = 'utf8mb4_general_ci';
        $textType = $this->getTextType();
        $textType->setCollation($collation);

        $this->assertTrue($textType->hasCollation());
        $this->assertSame($collation, $textType->getCollation());
    }

    public function testCast()
    {
        $textType = $this->getTextType();

        $this->assertSame('123', $textType->cast(123));
    }

    /**
     * @see testDDL
     * @return array
     */
    public function DDLProvider()
    {
        $collation = 'utf8mb4_general_ci';
        $textType = $this->createTextType();
        $textTypeCollate = $this->createTextType();
        $textTypeCollate->setCollation($collation);

        return [
            [
                strtoupper($textType->getType()),
                $textType
            ],
            [
                strtoupper($textTypeCollate->getType()) . " COLLATE '$collation'",
                $textTypeCollate
            ]
        ];
    }
}
