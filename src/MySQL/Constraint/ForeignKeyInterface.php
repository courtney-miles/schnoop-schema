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

    /**
     * @return IndexedColumn[]
     */
    public function getReferenceColumnNames();

    public function setReferenceColumns(TableInterface $table, array $columnNames);

    public function getOnDeleteAction();

    public function setOnDeleteAction($onDeleteAction);

    public function getOnUpdateAction();

    public function setOnUpdateAction($onUpdateAction);
}
