<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Index;

abstract class AbstractIndex implements IndexInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var IndexedColumnInterface[]
     */
    protected $indexedColumns;

    /**
     * @var string
     */
    protected $indexType;

    /**
     * @var string
     */
    protected $comment;

    /**
     * Index constructor.
     * @param string $name
     * @param IndexedColumnInterface[] $indexedColumns
     * @param string $indexType
     * @param string $comment
     */
    public function __construct($name, array $indexedColumns, $indexType, $comment)
    {
        $this->name = $name;
        $this->indexedColumns = $indexedColumns;
        $this->indexType = $indexType;
        $this->comment = $comment;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getIndexType()
    {
        return $this->indexType;
    }

    /**
     * @return IndexedColumnInterface[]
     */
    public function getIndexedColumns()
    {
        return $this->indexedColumns;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function hasComment()
    {
        return (bool)strlen($this->comment);
    }

    protected function makeIndexDDL($type, $name = null, $indexType = null)
    {
        return implode(
            ' ',
            array_filter(
                [
                    strtoupper($type),
                    $name !== null ? '`' . $name . '`' : null,
                    isset($indexType) ? 'USING ' . $indexType : null,
                    $this->makeIndexedColumnsDDL(),
                    $this->hasComment() ? "COMMENT '" . addslashes($this->getComment()) . "'" : null
                ]
            )
        );
    }

    protected function makeIndexedColumnsDDL()
    {
        $columnNames = [];

        foreach ($this->indexedColumns as $indexedColumn) {
            $columnNames[] = '`' . $indexedColumn->getColumnName() . '`'
                . ($indexedColumn->hasLength() ? '(' . $indexedColumn->getLength() . ')' : null)
                . ' ' . strtoupper($indexedColumn->getCollation());
        }

        return '(' . implode(',', $columnNames) . ')';
    }
}
