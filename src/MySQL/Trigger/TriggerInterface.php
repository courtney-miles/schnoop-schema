<?php
namespace MilesAsylum\SchnoopSchema\MySQL\Trigger;

use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;
use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;

interface TriggerInterface extends MySQLInterface
{
    /**
     * MySQL keyword for insert event.
     */
    const EVENT_INSERT = 'INSERT';

    /**
     * MySQL keyword for update event.
     */
    const EVENT_UPDATE = 'UPDATE';

    /**
     * MySQL keyword for delete event.
     */
    const EVENT_DELETE = 'DELETE';

    /**
     * MySQL keyword for before timing event.
     */
    const TIMING_BEFORE = 'BEFORE';

    /**
     * MySQL keyword for after timing event.
     */
    const TIMING_AFTER = 'AFTER';

    /**
     * MySQL keyword for trigger position proceeding another trigger.
     */
    const POSITION_PRECEDES = 'PRECEDES';

    /**
     * MySQL keyword for trigger position following another trigger.
     */
    const POSITION_FOLLOWS = 'FOLLOWS';

    /**
     * Get the trigger name.
     * @return string
     */
    public function getName();

    /**
     * Set the trigger name.
     * @param string $name The trigger name.
     */
    public function setName($name);

    /**
     * Get the table name for the trigger.
     * @return string Table name.
     */
    public function getTableName();

    /**
     * Set the table name for the trigger.
     * @param string $tableName Table name.
     */
    public function setTableName($tableName);

    /**
     * Get the database name for the trigger.
     * @return string Database name.
     */
    public function getDatabaseName();

    /**
     * Identify if a database name is set for the trigger.
     * @return true True if a database name is set.
     */
    public function hasDatabaseName();

    /**
     * Set the database name for the trigger.
     * @param string $databaseName Database name.
     */
    public function setDatabaseName($databaseName);

    /**
     * Get event for the trigger.
     * @return string One of the self::EVENT_* constants.
     */
    public function getEvent();

    /**
     * Set the event for trigger.
     * @param string $event One of the self::EVENT_* constants.
     */
    public function setEvent($event);

    /**
     * Get the timing for the trigger.
     * @return string One of the self::TIMING_* constants.
     */
    public function getTiming();

    /**
     * Set the timing for the trigger.
     * @param string $timing One of the self::TIMING_* constants.
     */
    public function setTiming($timing);

    /**
     * Get the trigger definer.
     * @return string Trigger definer.
     */
    public function getDefiner();

    /**
     * Identify if a definer is set for the trigger.
     * @return mixed True if a definer is set.
     */
    public function hasDefiner();

    /**
     * Set the definer for trigger.
     * @param string $definer Trigger definer.
     */
    public function setDefiner($definer);

    /**
     * Get the logic for the body of trigger.
     * @return string Trigger body.
     */
    public function getBody();

    /**
     * Identify if the trigger has a body defined.
     * @return bool True if trigger has a body.
     */
    public function hasBody();

    /**
     * SEt the logic for the body of the trigger.
     * @param string $body Trigger body.
     */
    public function setBody($body);

    /**
     * Get the context for the position of the trigger.
     * @return string One of the self::POSITION_* constants.
     */
    public function getPositionContext();

    /**
     * Get the name of the trigger this trigger is positioned relative to.
     * @return string Other trigger name.
     */
    public function getPositionRelativeTo();

    /**
     * Identify if the trigger has a specified position.
     * @return bool True if a position is set.
     */
    public function hasPosition();

    /**
     * Set the position of the trigger relative to another trigger.
     * @param string $positionContext One of the self::POSITION_* constants.
     * @param string $relativeTo Other trigger name.
     */
    public function setPosition($positionContext, $relativeTo);

    /**
     * Set an explicit SQL mode for the trigger.
     * @return SqlMode SQL mode.
     */
    public function getSqlMode();

    /**
     * Identify if an SQL mode is set for the trigger.
     * @return bool True if the SQL mode is set.
     */
    public function hasSqlMode();

    /**
     * Set an explicit SQL mode for the trigger.
     * @param SqlMode $sqlMode The SQL mode.
     */
    public function setSqlMode(SqlMode $sqlMode);

    /**
     * Unset the SQL mode for the trigger.
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
     * Get the DDL create statement for the trigger.
     * @return string
     */
    public function getDDL();

    /**
     * The DDL create statement for the trigger.
     * @uses TriggerInterface::getDDL()
     * @return string
     */
    public function __toString();
}
