<?php

namespace MilesAsylum\SchnoopSchema;

interface TableInterface
{
    public function getName();
    public function getColumnList();
    public function getColumns();
    public function hasColumn($columnName);
    public function getColumn($columnName);
    public function getIndexList();
    public function getIndexes();
    public function hasIndex($indexName);
    public function getIndex($indexName);
    public function hasPrimaryKey();
    public function getPrimaryKey();
    public function __toString();
}
