<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractOptionsType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use PHPUnit_Framework_MockObject_MockObject;

class AbstractOptionsTypeSchemaTest extends SchnoopSchemaTestCase
{
    /**
     * @dataProvider constructedProvider
     * @param array $options
     * @param string $collation
     * @param string $expectedDDL
     */
    public function testConstructed(
        array $options,
        $collation,
        $expectedDDL
    ) {
        /** @var AbstractOptionsType|PHPUnit_Framework_MockObject_MockObject $abstractOptionsType */
        $abstractOptionsType = $this->getMockForAbstractClass(
            AbstractOptionsType::class,
            [
                $options,
                $collation
            ]
        );
        $abstractOptionsType->method('getType')->willReturn('FOO');

        $this->assertTrue($abstractOptionsType->doesAllowDefault());
        $this->assertSame($options, $abstractOptionsType->getOptions());
        $this->assertSame($collation, $abstractOptionsType->getCollation());
        $this->assertSame($expectedDDL, (string)$abstractOptionsType);
    }

    /**
     * @see testConstructed
     * @return array
     */
    public function constructedProvider()
    {
        return [
            [
                [
                    'one',
                    'two'
                ],
                'utf8mb4_general_ci',
                "FOO('one','two') COLLATE utf8mb4_general_ci"
            ]
        ];
    }
}
