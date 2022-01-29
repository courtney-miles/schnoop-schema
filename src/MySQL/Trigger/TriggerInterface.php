<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Trigger;

use MilesAsylum\SchnoopSchema\MySQL\CreateStatementInterface;
use MilesAsylum\SchnoopSchema\MySQL\DroppableInterface;
use MilesAsylum\SchnoopSchema\MySQL\FullyQualifiedNameInterface;
use MilesAsylum\SchnoopSchema\MySQL\HasDefinerInterface;
use MilesAsylum\SchnoopSchema\MySQL\HasDelimiterInterface;
use MilesAsylum\SchnoopSchema\MySQL\HasSqlModeInterface;
use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

interface TriggerInterface extends MySQLInterface, HasDelimiterInterface, DroppableInterface, CreateStatementInterface, FullyQualifiedNameInterface, HasSqlModeInterface, HasDefinerInterface
{
    /**
     * MySQL keyword for insert event.
     */
    public const EVENT_INSERT = 'INSERT';

    /**
     * MySQL keyword for update event.
     */
    public const EVENT_UPDATE = 'UPDATE';

    /**
     * MySQL keyword for delete event.
     */
    public const EVENT_DELETE = 'DELETE';

    /**
     * MySQL keyword for before timing event.
     */
    public const TIMING_BEFORE = 'BEFORE';

    /**
     * MySQL keyword for after timing event.
     */
    public const TIMING_AFTER = 'AFTER';

    /**
     * MySQL keyword for trigger position proceeding another trigger.
     */
    public const POSITION_PRECEDES = 'PRECEDES';

    /**
     * MySQL keyword for trigger position following another trigger.
     */
    public const POSITION_FOLLOWS = 'FOLLOWS';

    /**
     * Get the trigger name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set the trigger name.
     *
     * @param string $name the trigger name
     */
    public function setName($name);

    /**
     * Get the table name for the trigger.
     *
     * @return string table name
     */
    public function getTableName();

    /**
     * Set the table name for the trigger.
     *
     * @param string $tableName table name
     */
    public function setTableName($tableName);

    /**
     * Get the database name for the trigger.
     *
     * @return string database name
     */
    public function getDatabaseName();

    /**
     * Identify if a database name is set for the trigger.
     *
     * @return true true if a database name is set
     */
    public function hasDatabaseName();

    /**
     * Set the database name for the trigger.
     *
     * @param string $databaseName database name
     */
    public function setDatabaseName($databaseName);

    /**
     * Get event for the trigger.
     *
     * @return string one of the self::EVENT_* constants
     */
    public function getEvent();

    /**
     * Set the event for trigger.
     *
     * @param string $event one of the self::EVENT_* constants
     */
    public function setEvent($event);

    /**
     * Get the timing for the trigger.
     *
     * @return string one of the self::TIMING_* constants
     */
    public function getTiming();

    /**
     * Set the timing for the trigger.
     *
     * @param string $timing one of the self::TIMING_* constants
     */
    public function setTiming($timing);

    /**
     * Get the logic for the body of trigger.
     *
     * @return string trigger body
     */
    public function getBody();

    /**
     * Identify if the trigger has a body defined.
     *
     * @return bool true if trigger has a body
     */
    public function hasBody();

    /**
     * SEt the logic for the body of the trigger.
     *
     * @param string $body trigger body
     */
    public function setBody($body);

    /**
     * Get the context for the position of the trigger.
     *
     * @return string one of the self::POSITION_* constants
     */
    public function getPositionContext();

    /**
     * Get the name of the trigger this trigger is positioned relative to.
     *
     * @return string other trigger name
     */
    public function getPositionRelativeTo();

    /**
     * Identify if the trigger has a specified position.
     *
     * @return bool true if a position is set
     */
    public function hasPosition();

    /**
     * Set the position of the trigger relative to another trigger.
     *
     * @param string $positionContext one of the self::POSITION_* constants
     * @param string $relativeTo other trigger name
     */
    public function setPosition($positionContext, $relativeTo);

    /**
     * The DDL create statement for the trigger.
     *
     * @uses TriggerInterface::getCreateStatement()
     *
     * @return string
     */
    public function __toString();
}
