<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

interface IndexInterface extends ConstraintInterface
{
    public const INDEX_TYPE_BTREE = 'BTREE';
    public const INDEX_TYPE_HASH = 'HASH';
    public const INDEX_TYPE_FULLTEXT = 'FULLTEXT';
    public const INDEX_TYPE_RTREE = 'RTREE';

    /**
     * Get indexed columns.
     *
     * @return IndexedColumnInterface[]
     */
    public function getIndexedColumns();

    /**
     * Identify if the index has any columns set.
     *
     * @return bool
     */
    public function hasIndexedColumns();

    /**
     * Set the columns for the index.
     *
     * @param IndexedColumnInterface[] $indexedColumns
     */
    public function setIndexedColumns(array $indexedColumns);

    /**
     * Add a column to the index.
     */
    public function addIndexedColumn(IndexedColumnInterface $indexedColumn);

    /**
     * Get the name of columns in the index.
     *
     * @return array column names
     */
    public function getIndexedColumnNames();

    /**
     * Get the index type.
     *
     * @return string Index type. One of self::INDEX_TYPE_* constants.
     */
    public function getIndexType();

    /**
     * Set a comment for the index.
     *
     * @param $comment
     */
    public function setComment($comment);

    /**
     * Get the comment for the index.
     *
     * @return string
     */
    public function getComment();

    /**
     * Identify if a comment is set for the index.
     *
     * @return bool
     */
    public function hasComment();
}
