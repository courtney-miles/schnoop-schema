<?php
namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;
use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;

interface RoutineInterface extends MySQLInterface
{
    const DATA_ACCESS_CONTAINS_SQL = 'CONTAINS SQL';
    const DATA_ACCESS_NO_SQL = 'NO SQL';
    const DATA_ACCESS_READS_SQL_DATA = 'READS SQL DATA';
    const DATA_ACCESS_MODIFIES_SQL_DATA = 'MODIFIES SQL DATA';
    const SECURITY_DEFINER = 'DEFINER';
    const SECURITY_INVOKER = 'INVOKER';

    /**
     * Get the routine name.
     * @return string
     */
    public function getName();

    /**
     * Get the database name.
     * @return string
     */
    public function getDatabaseName();

    /**
     * Identify if a database name is set for the routine.
     * @return bool
     */
    public function hasDatabaseName();

    /**
     * Set the database name.
     * @param string $databaseName
     */
    public function setDatabaseName($databaseName);

    /**
     * Get the routine definer.
     * @return string
     */
    public function getDefiner();

    /**
     * Set the routine definer.
     * @param string $definer
     */
    public function setDefiner($definer);

    /**
     * Get the routine comment.
     * @return string
     */
    public function getComment();

    /**
     * Set the routine comment.
     * @param string $comment
     */
    public function setComment($comment);

    /**
     * Identify if the routine has a comment.
     * @return bool True if a comment is set.
     */
    public function hasComment();

    /**
     * Identify if the routine is deterministic.
     * @return boolean True if the routine is deterministic.
     */
    public function isDeterministic();

    /**
     * Set if the routine is deterministic.
     * @param boolean $deterministic Set to true for if the routine is deterministic.
     */
    public function setDeterministic($deterministic);

    /**
     * Get the data access for the routine.
     * @return string One of RoutineInterface::DATA_ACCESS_* constants.
     */
    public function getDataAccess();

    /**
     * Set the data access for the routine.
     * @param string $contains One of RoutineInterface::DATA_ACCESS_* constants.
     */
    public function setDataAccess($contains);

    /**
     * Get the SQL security for the routine.
     * @return string One of RoutineInterface::SECURITY_* constants.
     */
    public function getSqlSecurity();

    /**
     * Set the SQL security for the routine.
     * @param mixed $sqlSecurity One of RoutineInterface::SECURITY_* constants.
     */
    public function setSqlSecurity($sqlSecurity);

    /**
     * Get the routine body.
     * @return string
     */
    public function getBody();

    /**
     * Set the routine body.
     * @param string $body
     */
    public function setBody($body);

    /**
     * Get the SQL Mode.
     * @return SqlMode
     */
    public function getSqlMode();

    /**
     * Identify if the SQL mode is set.
     * @return bool
     */
    public function hasSqlMode();

    /**
     * Set the SQL Mode.
     * @param SqlMode $sqlMode
     */
    public function setSqlMode(SqlMode $sqlMode);

    /**
     * Unset the SQL mode for the routine.
     */
    public function unsetSqlMode();

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
     * Indicates if the DDL will use the fully qualified name for the table.
     * @return bool
     */
    public function isDDLUseFullyQualifiedName();

    /**
     * Set if the DDL should use the fully qualified name for the table.
     * @param bool $useFullyQualifiedName
     */
    public function setDDLUseFullyQualifiedName($useFullyQualifiedName);

    /**
     * Get the DDL statement for the routine.
     * @return string DDL statement
     */
    public function getDDL();

    /**
     * DDL statement for the routine.
     * @return string
     */
    public function __toString();
}
