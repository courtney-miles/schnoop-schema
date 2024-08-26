<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

interface ForeignKeyInterface extends ConstraintInterface
{
    public const REFERENCE_ACTION_RESTRICT = 'RESTRICT';
    public const REFERENCE_ACTION_CASCADE = 'CASCADE';
    public const REFERENCE_ACTION_SET_NULL = 'SET NULL';
    public const REFERENCE_ACTION_NO_ACTION = 'NO ACTION';

    /**
     * Get the reference table for the foreign key.
     *
     * @return string reference table name
     */
    public function getReferenceTableName();

    /**
     * Identify if the name of the reference table has been set for the foreign key.
     *
     * @return bool
     */
    public function hasReferenceTableName();

    /**
     * Set the name of the reference table for the foreign key.
     *
     * @param string $tableName reference table name
     */
    public function setReferenceTableName($tableName);

    /**
     * Get the foreign key columns.
     *
     * @return ForeignKeyColumnInterface[] foreign key columns
     */
    public function getForeignKeyColumns();

    /**
     * Identify if any foreign key columns have been set.
     *
     * @return bool true if at least one column has been set for the foreign key
     */
    public function hasForeignKeyColumns();

    /**
     * Identifies if the foreign key includes the specified column.
     *
     * @return bool true if the column exists in the foreign key
     */
    public function hasForeignKeyColumn($columnName);

    /**
     * Set the foreign key columns.
     *
     * @param ForeignKeyColumnInterface[] $foreignKeyColumns foreign key columns
     */
    public function setForeignKeyColumns(array $foreignKeyColumns);

    /**
     * Add a foreign key column.
     *
     * @param ForeignKeyColumnInterface $foreignKeyColumn foreign key column
     */
    public function addForeignKeyColumn(ForeignKeyColumnInterface $foreignKeyColumn);

    /**
     * Get the names of the columns for the foreign key.
     *
     * @return array column names
     */
    public function getColumnNames();

    /**
     * Get reference column names for the foreign key.
     *
     * @return array reference column names
     */
    public function getReferenceColumnNames();

    /**
     * Identify if the supplied column name is one of the reference columns for the foreign key.
     *
     * @param string $columnName
     * @param string|null $tableName optionally include the table name with the check
     *
     * @return bool
     */
    public function hasReferenceColumnName($columnName, $tableName = null);

    /**
     * Get the action to perform against the reference table when a row is deleted.
     *
     * @return string Deletion action. One of self::REFERENCE_ACTION_* constants.
     */
    public function getOnDeleteAction();

    /**
     * Set the action against the reference table when a row is deleted.
     *
     * @param string $onDeleteAction Deletion action. One of self::REFERENCE_ACTION_* constants.
     */
    public function setOnDeleteAction($onDeleteAction);

    /**
     * Get the action to perform against the reference table when the foreign key columns are updated.
     *
     * @return string Update action. One of self::REFERENCE_ACTION_* constants.
     */
    public function getOnUpdateAction();

    /**
     * Set the action to perform against the reference table when the foreign key columns are updated.
     *
     * @param string $onUpdateAction Update action. One of self::REFERENCE_ACTION_* constants.
     */
    public function setOnUpdateAction($onUpdateAction);
}
