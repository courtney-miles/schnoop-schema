<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Database;

use MilesAsylum\SchnoopSchema\MySQL\Database\Database;
use MilesAsylum\SchnoopSchema\MySQL\DroppableInterface;
use MilesAsylum\SchnoopSchema\MySQL\HasDelimiterInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;

class DatabaseTest extends SchnoopSchemaTestCase
{
    /**
     * @var Database
     */
    protected $database;

    protected $name = 'schnoop';

    protected $collation = 'utf8_general_ci';

    protected $tableList = [
        'schnoop_table_one',
        'schnoop_table_two',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->database = new Database($this->name);
    }

    public function testName(): void
    {
        $this->assertSame($this->name, $this->database->getName());
    }

    public function testInitialProperties(): void
    {
        $this->assertFalse($this->database->hasDefaultCollation());
        $this->assertNull($this->database->getDefaultCollation());
        $this->assertSame(HasDelimiterInterface::DEFAULT_DELIMITER, $this->database->getDelimiter());
        $this->assertSame(DroppableInterface::DDL_DROP_POLICY_DO_NOT_DROP, $this->database->getDropPolicy());
    }

    public function testDefaultCollationUndefined(): void
    {
        $this->assertFalse($this->database->hasDefaultCollation());
        $this->assertNull($this->database->getDefaultCollation());
    }

    public function testSetDefaultCollation(): void
    {
        $collation = 'utf8_general_ci';
        $this->database->setDefaultCollation($collation);

        $this->assertTrue($this->database->hasDefaultCollation());
        $this->assertSame($collation, $this->database->getDefaultCollation());
    }

    public function testSetDDLDropPolicy(): void
    {
        $this->database->setDropPolicy(Database::DDL_DROP_POLICY_DROP_IF_EXISTS);

        $this->assertSame(Database::DDL_DROP_POLICY_DROP_IF_EXISTS, $this->database->getDropPolicy());
    }

    public function testSetDDLDelimiter(): void
    {
        $this->database->setDelimiter('@@');

        $this->assertSame('@@', $this->database->getDelimiter());
    }

    /**
     * @dataProvider DDLProvider
     *
     * @param Database $database
     */
    public function testDDL($database, $expectedDDL): void
    {
        $this->assertSame($expectedDDL, $database->getCreateStatement());
    }

    public function testToStringAliasesGetDDL(): void
    {
        $ddl = '__ddl__';

        $mockDatabase = $this->getMockBuilder(Database::class)
            ->setConstructorArgs(
                [$this->name]
            )->setMethods(
                ['getCreateStatement']
            )->getMock();

        $mockDatabase->expects($this->once())
            ->method('getCreateStatement')
            ->willReturn($ddl);

        $this->assertSame($ddl, (string) $mockDatabase);
    }

    /**
     * @see testDDL
     *
     * @return array
     */
    public function DDLProvider()
    {
        $dbName = 'schnoop_db';

        return [
            'Basic database' => [
                $this->createDatabase($dbName, null, ';', Database::DDL_DROP_POLICY_DO_NOT_DROP),
                <<<SQL
CREATE DATABASE `{$dbName}`;
SQL
            ],
            'Database with collation' => [
                $this->createDatabase($dbName, 'utf8_general_ci', ';', Database::DDL_DROP_POLICY_DO_NOT_DROP),
                <<<SQL
CREATE DATABASE `{$dbName}` DEFAULT COLLATE 'utf8_general_ci';
SQL
            ],
            'Drop' => [
                $this->createDatabase($dbName, null, ';', Database::DDL_DROP_POLICY_DROP),
                <<<SQL
DROP DATABASE `{$dbName}`;
CREATE DATABASE `{$dbName}`;
SQL
            ],
            'Drop if exists' => [
                $this->createDatabase($dbName, null, ';', Database::DDL_DROP_POLICY_DROP_IF_EXISTS),
                <<<SQL
DROP DATABASE IF EXISTS `{$dbName}`;
CREATE DATABASE `{$dbName}`;
SQL
            ],
            'Drop if exists with custom delimiter' => [
                $this->createDatabase($dbName, null, '@@', Database::DDL_DROP_POLICY_DROP_IF_EXISTS),
                <<<SQL
DROP DATABASE IF EXISTS `{$dbName}`@@
CREATE DATABASE `{$dbName}`@@
SQL
            ],
        ];
    }

    protected function createDatabase($name, $defaultCollation, $ddlDelimiter, $ddlDropPolicy)
    {
        $db = new Database($name);
        $db->setDefaultCollation($defaultCollation);
        $db->setDelimiter($ddlDelimiter);
        $db->setDropPolicy($ddlDropPolicy);

        return $db;
    }
}
