<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

abstract class AbstractIndex extends AbstractConstraint implements IndexInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var IndexedColumnInterface[]
     */
    protected $indexedColumns = [];

    /**
     * @var string
     */
    protected $indexType;

    /**
     * @var string
     */
    protected $comment;

    public function __construct($name, $constraintType, $indexType = null)
    {
        parent::__construct($name, $constraintType);

        $this->setIndexType($indexType);
    }

    public function getIndexedColumns()
    {
        return array_values($this->indexedColumns);
    }

    /**
     * @param array $indexedColumns
     * @return mixed
     */
    public function setIndexedColumns(array $indexedColumns)
    {
        $this->indexedColumns = [];

        foreach ($indexedColumns as $indexedColumn) {
            $this->addIndexedColumn($indexedColumn);
        }
    }

    public function hasIndexedColumns()
    {
        return !empty($this->indexedColumns);
    }

    public function addIndexedColumn(IndexedColumnInterface $indexedColumn)
    {
        $this->indexedColumns[$indexedColumn->getColumnName()] = $indexedColumn;
    }

    public function getIndexedColumnNames()
    {
        return array_keys($this->indexedColumns);
    }

    public function getIndexType()
    {
        return $this->indexType;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function hasComment()
    {
        return (bool)strlen($this->comment);
    }


    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    protected function makeIndexDDL($type, $name = null, $indexType = null)
    {
        return implode(
            ' ',
            array_filter(
                [
                    strtoupper($type),
                    $name !== null ? '`' . $name . '`' : null,
                    //isset($indexType) ? 'USING ' . $indexType : null,
                    $this->makeIndexedColumnsDDL(),
                    $this->hasComment() ? "COMMENT '" . addslashes($this->getComment()) . "'" : null
                ]
            )
        );
    }

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

    protected function setIndexType($indexType)
    {
        $this->indexType = $indexType;
    }
}
