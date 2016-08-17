<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface;

interface ConstraintInterface
{
    const CONSTRAINT_INDEX = 'INDEX';
    const CONSTRAINT_UNIQUE = 'UNIQUE';
    const CONSTRAINT_FULLTEXT = 'FULLTEXT';
    const CONSTRAINT_SPATIAL = 'SPATIAL';
    const CONSTRAINT_FOREIGN = 'FOREIGN';

    public function getName();

    public function getTable();

    public function setTable(TableInterface $table);

    /**
     * Identify if the index has been attached to a table.
     * @return bool True if the index has been attached to a table.
     */
    public function hasTable();

    public function getIndexedColumns();

    /**
     * @param array $indexedColumns
     * @return mixed
     */
    public function setIndexedColumns(array $indexedColumns);

    /**
     * @return bool
     */
    public function hasIndexedColumns();

    public function __toString();

    public function getConstraintType();
}
