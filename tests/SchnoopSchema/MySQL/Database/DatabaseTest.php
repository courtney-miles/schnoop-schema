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

        $this->database = new Database($this->name);

        $this->ddl = "CREATE DATABASE `{$this->name}` DEFAULT COLLATE '{$this->collation}'";
    }

    public function testName()
    {
        $this->assertSame($this->name, $this->database->getName());
    }

    public function testDefaultCollationUndefined()
    {
        $this->assertFalse($this->database->hasDefaultCollation());
        $this->assertNull($this->database->getDefaultCollation());
    }

    public function testSetDefaultCollation()
    {
        $collation = 'utf8_general_ci';
        $this->database->setDefaultCollation($collation);

        $this->assertTrue($this->database->hasDefaultCollation());
        $this->assertSame($collation, $this->database->getDefaultCollation());
    }

    /**
     * @dataProvider DDLProvider
     * @param $database
     * @param $expectedDDL
     */
    public function testDDL($database, $expectedDDL)
    {
        $this->assertSame($expectedDDL, (string)$database);
    }

    /**
     * @see testDDL
     * @return array
     */
    public function DDLProvider()
    {
        $dbWithCollation = new Database('foo');
        $dbWithCollation->setDefaultCollation('utf8_general_ci');

        return [
            [
                new Database('foo'),
                'CREATE DATABASE `foo`;'
            ],
            [
                $dbWithCollation,
                "CREATE DATABASE `foo` DEFAULT COLLATE 'utf8_general_ci';"
            ]
        ];
    }
}
