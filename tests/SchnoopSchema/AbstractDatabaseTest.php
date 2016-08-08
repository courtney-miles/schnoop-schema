<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 29/06/16
 * Time: 7:11 AM
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema;

use MilesAsylum\SchnoopSchema\AbstractDatabase;
use PHPUnit\Framework\TestCase;

class AbstractDatabaseTest extends TestCase
{
    /**
     * @var AbstractDatabase
     */
    protected $abstractCommonDatabase;

    protected $name = 'schnoop_database';

    public function setUp()
    {
        parent::setUp();

        $this->abstractCommonDatabase = $this->getMockForAbstractClass(
            AbstractDatabase::class,
            [$this->name]
        );
    }

    public function testConstruct()
    {
        $this->assertSame($this->name, $this->abstractCommonDatabase->getName());
    }
}
