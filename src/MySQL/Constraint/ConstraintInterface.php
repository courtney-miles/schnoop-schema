<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

interface ConstraintInterface extends MySQLInterface
{
    /**
     * MySQL keyword for index.
     */
    public const CONSTRAINT_INDEX = 'INDEX';

    /**
     * MySQL keyword for unique index.
     */
    public const CONSTRAINT_INDEX_UNIQUE = 'UNIQUE INDEX';

    /**
     * MySQL keyword for fulltext index.
     */
    public const CONSTRAINT_INDEX_FULLTEXT = 'FULLTEXT INDEX';

    /**
     * MySQL keyword for spatial index.
     */
    public const CONSTRAINT_INDEX_SPATIAL = 'SPATIAL INDEX';

    /**
     * MySQL keyword for foreign key.
     */
    public const CONSTRAINT_FOREIGN_KEY = 'FOREIGN KEY';

    /**
     * Get the index name.
     *
     * @return string index name
     */
    public function getName();

    /**
     * Get the table name for the index.
     *
     * @return string table name
     */
    public function getTableName();

    /**
     * Set the table name for the index.
     *
     * @param string $tableName table Name
     */
    public function setTableName($tableName);

    /**
     * Identify if a table name is set for the index.
     *
     * @return bool true if a table name is set
     */
    public function hasTableName();

    /**
     * Get the database name for the index.
     *
     * @return string database name
     */
    public function getDatabaseName();

    /**
     * Identify if a database name is set for the index.
     *
     * @return bool true if a database name is set
     */
    public function hasDatabaseName();

    /**
     * Set the database name for the index.
     *
     * @param string $databaseName database name
     */
    public function setDatabaseName($databaseName);

    /**
     * Get the constraint type.
     *
     * @return mixed one of self::CONSTRAINT_* constants
     */
    public function getConstraintType();

    /**
     * Get the DDL descriptor for the index.
     *
     * @return string DDL descriptor for the index
     */
    public function getDDL();

    /**
     * DDL descriptor for the index.
     *
     * @uses ConstraintInterface::getDDL()
     *
     * @return string DDL descriptor for the index
     */
    public function __toString();
}
