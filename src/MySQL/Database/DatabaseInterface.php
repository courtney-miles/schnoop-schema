<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Database;

use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

interface DatabaseInterface extends MySQLInterface
{
    /**
     * Get the database name.
     * @return string The database name.
     */
    public function getName();

    /**
     * Get the default collation for the database;
     * @return string The default collation.
     */
    public function getDefaultCollation();

    /**
     * Identify if a default collation has been set.
     * @return bool True if the default collation is set.
     */
    public function hasDefaultCollation();

    /**
     * Set the default collation for the database.
     * @param string $defaultCollation
     */
    public function setDefaultCollation($defaultCollation);

    /**
     * Get the delimiter used between DDL statements.
     * @return string
     */
    public function getDDLDelimiter();

    /**
     * Set the delimiter to use between DDL statements.
     * @param string $delimiter
     */
    public function setDDLDelimiter($delimiter);

    /**
     * Identify if drop statement will be included with DDL create statement.
     * @return int Will return the value of one of the self::DDL_DROP_* constants.
     */
    public function getDDLDropPolicy();

    /**
     * Set if the DDL should include a statement to drop the database.
     * @param int $ddlDropPolicy Supply one of the self::DDL_DROP_* constants.
     */
    public function setDDLDropPolicy($ddlDropPolicy);

    /**
     * Gets the DDL statement for the database.
     * @return string Create DDL statement for the database.
     */
    public function getDDL();

    /**
     * The DDL statement for the database;
     * @uses DatabaseInterface::getDDL();
     * @return string Create DDL statement for the database.
     */
    public function __toString();
}
