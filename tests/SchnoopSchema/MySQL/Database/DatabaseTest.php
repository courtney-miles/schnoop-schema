<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 8/06/16
 * Time: 7:59 AM
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Database;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Database\Database;

class DatabaseTest extends SchnoopSchemaTestCase
{
    /**
     * @var Database
     */
    protected $database;

    protected $name = 'schnoop';

    protected $collation = 'utf8_general_ci';

    protected $ddl;

    protected $tableList = [
        'schnoop_table_one',
        'schnoop_table_two'
    ];

    protected function setUp()
    {
        parent::setUp();

        $this->database = new Database($this->name, $this->collation);

        $this->ddl = "CREATE DATABASE `{$this->name}` DEFAULT COLLATE '{$this->collation}'";
    }

    public function testConstructed()
    {
        $this->assertSame($this->name, $this->database->getName());
        $this->assertSame($this->collation, $this->database->getDefaultCollation());
        $this->assertSame($this->ddl, (string)$this->database);
    }
}
