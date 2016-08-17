<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

interface IndexInterface extends ConstraintInterface
{
    const INDEX_TYPE_BTREE = 'BTREE';
    const INDEX_TYPE_HASH = 'HASH';
    const INDEX_TYPE_FULLTEXT = 'FULLTEXT';
    const INDEX_TYPE_RTREE = 'RTREE';

    public function getIndexType();

    public function setComment($comment);

    public function getComment();

    public function hasComment();
}
