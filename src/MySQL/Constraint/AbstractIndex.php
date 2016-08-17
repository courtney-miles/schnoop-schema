<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface;

abstract class AbstractIndex extends AbstractConstraint implements IndexInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var TableInterface
     */
    protected $table;

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

    public function getName()
    {
        return $this->name;
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
//                    isset($indexType) ? 'USING ' . $indexType : null,
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
                . ' ' . strtoupper($indexedColumn->getCollation());
        }

        return '(' . implode(',', $columnDDLs) . ')';
    }

    protected function setIndexType($indexType)
    {
        $this->indexType = $indexType;
    }
}
