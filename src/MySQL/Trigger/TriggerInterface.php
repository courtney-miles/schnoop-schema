<?php
namespace MilesAsylum\SchnoopSchema\MySQL\Trigger;

use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;
use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;

interface TriggerInterface extends MySQLInterface
{
    const EVENT_INSERT = 'INSERT';
    const EVENT_UPDATE = 'UPDATE';
    const EVENT_DELETE = 'DELETE';

    const TIMING_BEFORE = 'BEFORE';
    const TIMING_AFTER = 'AFTER';

    const POSITION_PRECEDES = 'PRECEDES';
    const POSITION_FOLLOWS = 'FOLLOWS';

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getTableName();

    /**
     * @param string $tableName
     */
    public function setTableName($tableName);

    /**
     * @return string
     */
    public function getDatabaseName();

    public function hasDatabaseName();

    /**
     * @param string $databaseName
     */
    public function setDatabaseName($databaseName);

    /**
     * @return string
     */
    public function getEvent();

    /**
     * @param string $event
     */
    public function setEvent($event);

    /**
     * @return string
     */
    public function getTiming();

    /**
     * @param string $timing
     */
    public function setTiming($timing);

    /**
     * @return string
     */
    public function getDefiner();

    public function hasDefiner();

    /**
     * @param string $definer
     */
    public function setDefiner($definer);

    /**
     * @return string
     */
    public function getBody();

    /**
     * @return bool
     */
    public function hasBody();

    /**
     * @param string $body
     */
    public function setBody($body);

    /**
     * @return string
     */
    public function getPositionRelation();

    /**
     * @return string Other trigger name
     */
    public function getPositionRelativeTo();

    public function hasPosition();

    /**
     * @param string $relation
     * @param string $relativeTo Other trigger name
     */
    public function setPosition($relation, $relativeTo);

    /**
     * @return SqlMode
     */
    public function getSqlMode();

    /**
     * @return bool
     */
    public function hasSqlMode();

    /**
     * @param SqlMode $sqlMode
     */
    public function setSqlMode(SqlMode $sqlMode);

    public function getDDL(
        $forceSqlMode = false,
        $delimiter = self::DEFAULT_DELIMITER,
        $fullyQualifiedName = false,
        $drop = self::DDL_DROP_DO_NOT
    );

    public function __toString();
}
