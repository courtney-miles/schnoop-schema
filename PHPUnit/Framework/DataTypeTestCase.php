<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

abstract class DataTypeTestCase extends SchnoopSchemaTestCase
{
    /**
     * @see testDDL
     * @return array
     */
    abstract public function DDLProvider();

    /**
     * @dataProvider DDLProvider
     * @param $expectedDDL
     * @param DataTypeInterface $intType
     */
    public function testDDL($expectedDDL, DataTypeInterface $intType)
    {
        $this->assertSame($expectedDDL, (string)$intType);
    }
}
