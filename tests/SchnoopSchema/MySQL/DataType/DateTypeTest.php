<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 12/07/16
 * Time: 7:37 AM
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;


use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DateType;

class DateTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $dateType = new DateType();
        $dateStr = '2016-01-01';

        $this->assertSame(DataTypeInterface::TYPE_DATE, $dateType->getType());
        $this->assertTrue($dateType->doesAllowDefault());
        $this->assertSame($dateStr, $dateType->cast($dateStr));
    }
}
