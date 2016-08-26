<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface;

interface ConstraintInterface
{
    const CONSTRAINT_INDEX = 'INDEX';
    const CONSTRAINT_UNIQUE_INDEX = 'UNIQUE INDEX';
    const CONSTRAINT_FULLTEXT_INDEX = 'FULLTEXT INDEX';
    const CONSTRAINT_SPATIAL_INDEX = 'SPATIAL INDEX';
    const CONSTRAINT_FOREIGN_KEY = 'FOREIGN KEY';

    public function getName();

    public function getTableName();

    public function setTableName($tableName);

    /**
     * Identify if the index has been attached to a table.
     * @return bool True if the index has been attached to a table.
     */
    public function hasTableName();

    public function __toString();

    public function getConstraintType();
}
