<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

abstract class AbstractIndex extends AbstractConstraint implements IndexInterface
{
    /**
     * Indexed columns.
     * @var IndexedColumnInterface[]
     */
    protected $indexedColumns = [];

    /**
     * Index type.
     * @var string
     */
    protected $indexType;

    /**
     * Index comment.
     * @var string
     */
    protected $comment;

    /**
     * AbstractIndex constructor.
     * @param string $name Index name
     * @param string $constraintType Constraint type. One of self::CONSTRAINT_* constants.
     * @param null $indexType Index type. Either self::INDEX_TYPE_BTREE or self::INDEX_TYPE_HASH.
     */
    public function __construct($name, $constraintType, $indexType = null)
    {
        parent::__construct($name, $constraintType);

        $this->setIndexType($indexType);
    }

    /**
     * {@inheritdoc}
     */
    public function getIndexedColumns()
    {
        return array_values($this->indexedColumns);
    }

    /**
     * {@inheritdoc}
     */
    public function setIndexedColumns(array $indexedColumns)
    {
        $this->indexedColumns = [];

        foreach ($indexedColumns as $indexedColumn) {
            $this->addIndexedColumn($indexedColumn);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasIndexedColumns()
    {
        return !empty($this->indexedColumns);
    }

    /**
     * {@inheritdoc}
     */
    public function addIndexedColumn(IndexedColumnInterface $indexedColumn)
    {
        $this->indexedColumns[$indexedColumn->getColumnName()] = $indexedColumn;
    }

    /**
     * {@inheritdoc}
     */
    public function getIndexedColumnNames()
    {
        return array_keys($this->indexedColumns);
    }

    /**
     * {@inheritdoc}
     */
    public function getIndexType()
    {
        return $this->indexType;
    }

    /**
     * {@inheritdoc}
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * {@inheritdoc}
     */
    public function hasComment()
    {
        return (bool)strlen($this->comment);
    }

    /**
     * {@inheritdoc}
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Makes the DDL statement for the index.
     * @param string $type Index type
     * @param string|null $name Index name
     * @return string Index DDL
     */
    protected function makeIndexDDL($type, $name = null)
    {
        return implode(
            ' ',
            array_filter(
                [
                    strtoupper($type),
                    $name !== null ? '`' . $name . '`' : null,
                    $this->makeIndexedColumnsDDL(),
                    $this->hasComment() ? "COMMENT '" . addslashes($this->getComment()) . "'" : null
                ]
            )
        );
    }

    /**
     * Makes the column portion of the index DDL statement.
     * @return string Column portion of index DDL statement.
     */
    protected function makeIndexedColumnsDDL()
    {
        $columnDDLs = [];

        foreach ($this->indexedColumns as $indexedColumn) {
            $columnDDLs[] = '`' . $indexedColumn->getColumnName() . '`'
                . ($indexedColumn->hasLength() ? '(' . $indexedColumn->getLength() . ')' : null)
                . ($indexedColumn->hasCollation() ? ' ' . strtoupper($indexedColumn->getCollation()) : null);
        }

        return '(' . implode(',', $columnDDLs) . ')';
    }

    /**
     * Set the index type.
     * @param $indexType Index type. One of self::INDEX_TYPE_* constants.
     */
    protected function setIndexType($indexType)
    {
        $this->indexType = $indexType;
    }
}
