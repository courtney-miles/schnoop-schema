<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Index;

interface IndexInterface extends \MilesAsylum\SchnoopSchema\IndexInterface
{
    const INDEX_INDEX = 'index';
    const INDEX_UNIQUE = 'unique';
    const INDEX_FULLTEXT = 'fulltext';
    const INDEX_SPATIAL = 'spatial';

    const INDEX_TYPE_BTREE = 'BTREE';
    const INDEX_TYPE_HASH = 'HASH';
    const INDEX_TYPE_FULLTEXT = 'FULLTEXT';
    const INDEX_TYPE_RTREE = 'RTREE';

    public function getType();

    public function getIndexType();

    public function getIndexedColumns();

    public function getComment();

    public function hasComment();
}
