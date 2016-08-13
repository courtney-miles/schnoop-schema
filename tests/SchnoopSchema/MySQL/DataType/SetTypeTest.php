<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\SetType;

class SetTypeTest extends SchnoopSchemaTestCase
{
    /**
     * @var SetType
     */
    protected $setType;

    protected $options = [
        'foo',
        'bar'
    ];

    protected $charSet = 'utf8';

    protected $collation = 'utf8_general_ci';

    public function setUp()
    {
        parent::setUp();

        $this->setType = new SetType(
            $this->options,
            $this->collation
        );
    }

    public function testConstruct()
    {
        $this->assertSame(DataTypeInterface::TYPE_SET, $this->setType->getType());
        $this->assertSame($this->options, $this->setType->getOptions());
        $this->assertSame($this->collation, $this->setType->getCollation());
        $this->assertTrue($this->setType->doesAllowDefault());
    }

    public function testCast()
    {
        $value = [123];
        $expectedValue = ['123'];

        $this->assertSame($expectedValue, $this->setType->cast($value));
    }
}
