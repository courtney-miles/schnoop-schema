<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

interface ConstraintInterface extends MySQLInterface
{
    /**
     * MySQL keyword for index.
     */
    const CONSTRAINT_INDEX = 'INDEX';

    /**
     * MySQL keyword for unique index.
     */
    const CONSTRAINT_INDEX_UNIQUE = 'UNIQUE INDEX';

    /**
     * MySQL keyword for fulltext index.
     */
    const CONSTRAINT_INDEX_FULLTEXT = 'FULLTEXT INDEX';

    /**
     * MySQL keyword for spatial index.
     */
    const CONSTRAINT_INDEX_SPATIAL = 'SPATIAL INDEX';

    /**
     * MySQL keyword for foreign key.
     */
    const CONSTRAINT_FOREIGN_KEY = 'FOREIGN KEY';

    /**
     * Get the index name.
     * @return string Index name.
     */
    public function getName();

    /**
     * Get the table name for the index.
     * @return string Table name.
     */
    public function getTableName();

    /**
     * Set the table name for the index.
     * @param string $tableName Table Name.
     */
    public function setTableName($tableName);

    /**
     * Identify if a table name is set for the index.
     * @return bool True if a table name is set.
     */
    public function hasTableName();

    /**
     * Get the database name for the index.
     * @return string Database name.
     */
    public function getDatabaseName();

    /**
     * Identify if a database name is set for the index.
     * @return bool True if a database name is set.
     */
    public function hasDatabaseName();

    /**
     * Set the database name for the index.
     * @param string $databaseName Database name.
     */
    public function setDatabaseName($databaseName);

    /**
     * Get the constraint type.
     * @return mixed One of self::CONSTRAINT_* constants.
     */
    public function getConstraintType();

    /**
     * Get the DDL descriptor for the index.
     * @return string DDL descriptor for the index.
     */
    public function getDDL();

    /**
     * DDL descriptor for the index.
     * @uses ConstraintInterface::getDDL()
     * @return string DDL descriptor for the index.
     */
    public function __toString();
}
