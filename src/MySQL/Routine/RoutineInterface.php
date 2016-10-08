<?php
namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DDLStatementInterface;
use MilesAsylum\SchnoopSchema\MySQL\HasDefinerInterface;
use MilesAsylum\SchnoopSchema\MySQL\HasDelimiterInterface;
use MilesAsylum\SchnoopSchema\MySQL\DroppableInterface;
use MilesAsylum\SchnoopSchema\MySQL\FullyQualifiedNameInterface;
use MilesAsylum\SchnoopSchema\MySQL\HasSqlModeInterface;
use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;
use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;

interface RoutineInterface extends
    MySQLInterface,
    HasDelimiterInterface,
    DroppableInterface,
    DDLStatementInterface,
    FullyQualifiedNameInterface,
    HasSqlModeInterface,
    HasDefinerInterface
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
     * DDL statement for the routine.
     * @return string
     */
    public function __toString();
}
