<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

interface ConstraintInterface
{
    const CONSTRAINT_INDEX = 'INDEX';
    const CONSTRAINT_INDEX_UNIQUE = 'UNIQUE INDEX';
    const CONSTRAINT_INDEX_FULLTEXT = 'FULLTEXT INDEX';
    const CONSTRAINT_INDEX_SPATIAL = 'SPATIAL INDEX';
    const CONSTRAINT_FOREIGN_KEY = 'FOREIGN KEY';

    public function getName();

    public function getTableName();

    public function setTableName($tableName);

    public function hasTableName();

    public function getDatabaseName();

    public function hasDatabaseName();

    public function setDatabaseName($databaseName);

    public function __toString();

    public function getConstraintType();
}
