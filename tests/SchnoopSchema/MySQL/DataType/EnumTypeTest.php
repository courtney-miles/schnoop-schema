<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 8/07/16
 * Time: 4:23 PM
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\EnumType;

class EnumTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EnumType
     */
    protected $enumType;

    protected $options = [
        'foo',
        'bar'
    ];

    protected $charSet = 'utf8';

    protected $collation = 'utf8_general_ci';

    public function setUp()
    {
        parent::setUp();

        $this->enumType = new EnumType(
            $this->options,
            $this->collation
        );
    }

    public function testConstruct()
    {
        $this->assertSame(DataTypeInterface::TYPE_ENUM, $this->enumType->getType());
        $this->assertSame($this->options, $this->enumType->getOptions());
        $this->assertSame($this->collation, $this->enumType->getCollation());
        $this->assertTrue($this->enumType->doesAllowDefault());
    }

    public function testCast()
    {
        $value = 123;
        $this->assertSame((string)$value, $this->enumType->cast($value));
    }
}
