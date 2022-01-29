<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

abstract class DataTypeTestCase extends SchnoopSchemaTestCase
{
    /**
     * @see testDDL
     *
     * @return array
     */
    abstract public function DDLProvider();

    /**
     * @dataProvider DDLProvider
     *
     * @param $expectedDDL
     */
    public function testDDL($expectedDDL, DataTypeInterface $intType): void
    {
        $this->assertSame($expectedDDL, (string) $intType);
    }
}
