<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface;

interface ForeignKeyInterface extends ConstraintInterface
{
    const REFERENCE_ACTION_RESTRICT = 'RESTRICT';
    const REFERENCE_ACTION_CASCADE = 'CASCADE';
    const REFERENCE_ACTION_SET_NULL = 'SET NULL';
    const REFERENCE_ACTION_NO_ACTION = 'NO ACTION';

    public function getReferenceTable();

    public function hasReferenceTable();

    public function setReferenceTable(TableInterface $table);

    /**
     * @return ForeignKeyColumnInterface[]
     */
    public function getForeignKeyColumns();

    public function hasForeignKeyColumns();

    /**
     * @param ForeignKeyColumnInterface[] $foreignKeyColumns
     */
    public function setForeignKeyColumns(array $foreignKeyColumns);

    public function addForeignKeyColumn(ForeignKeyColumnInterface $foreignKeyColumn);

    public function getColumnNames();

    /**
     * @return array
     */
    public function getReferenceColumnNames();

    public function getOnDeleteAction();

    public function setOnDeleteAction($onDeleteAction);

    public function getOnUpdateAction();

    public function setOnUpdateAction($onUpdateAction);
}
