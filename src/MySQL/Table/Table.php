<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 2/06/16
 * Time: 5:01 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\Table;

use MilesAsylum\SchnoopSchema\AbstractTable;
use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexInterface;

class Table extends AbstractTable implements TableInterface
{
    protected $engine;

    protected $defaultCollation;

    protected $rowFormat;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var array|\MilesAsylum\SchnoopSchema\MySQL\Index\IndexInterface[]
     */
    protected $indexes;

    /**
     * Table constructor.
     * @param string $name
     * @param ColumnInterface[] $columns
     * @param IndexInterface[] $indexes
     * @param string $engine
     * @param string $rowFormat
     * @param string $collation
     * @param string $comment
     */
    public function __construct(
        $name,
        array $columns,
        array $indexes,
        $engine = null,
        $rowFormat = null,
        $collation = null,
        $comment = null
    ) {
        parent::__construct($name, $columns, $indexes);
        $this->setEngine($engine);
        $this->setDefaultCollation($collation);
        $this->setRowFormat($rowFormat);
        $this->setComment($comment);
        $this->setIndexes($indexes);
    }

    /**
     * @return mixed
     */
    public function getEngine()
    {
        return $this->engine;
    }

    public function hasEngine()
    {
        return !empty($this->engine);
    }

    /**
     * @return mixed
     */
    public function getDefaultCollation()
    {
        return $this->defaultCollation;
    }

    public function hasDefaultCollation()
    {
        return !empty($this->defaultCollation);
    }

    /**
     * @return mixed
     */
    public function getRowFormat()
    {
        return $this->rowFormat;
    }

    public function hasRowFormat()
    {
        return !empty($this->rowFormat);
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    public function hasComment()
    {
        return strlen($this->comment);
    }

    public function __toString()
    {
        $columnDefinitions = [];
        foreach ($this->getColumns() as $column) {
            $columnDefinitions[] = (string)$column;
        }

        $indexDefinitions = [];
        foreach ($this->getIndexes() as $index) {
            $indexDefinitions[] = (string)$index;
        }

        $tableOptions = array_filter(
            [
                $this->hasEngine() ? 'ENGINE = ' . strtoupper($this->getEngine()) : null,
                $this->hasDefaultCollation() ? "DEFAULT COLLATE = '" . $this->getDefaultCollation() . "'" : null,
                $this->hasRowFormat() ? 'ROW_FORMAT = ' . strtoupper($this->getRowFormat()) : null,
                $this->hasComment() ? "COMMENT = '" . addslashes($this->getComment()) . "'" : null
            ]
        );

        return 'CREATE TABLE `' . $this->name . "` (\n    "
            . implode(",\n    ", array_merge($columnDefinitions, $indexDefinitions))
            . "\n)\n"
            . implode("\n", $tableOptions)
            . ';';
    }

    /**
     * @param mixed $engine
     */
    protected function setEngine($engine)
    {
        $this->engine = $engine;
    }

    /**
     * @param mixed $defaultCollation
     */
    protected function setDefaultCollation($defaultCollation)
    {
        $this->defaultCollation = $defaultCollation;
    }

    /**
     * @param mixed $rowFormat
     */
    protected function setRowFormat($rowFormat)
    {
        $this->rowFormat = $rowFormat;
    }

    /**
     * @param mixed $comment
     */
    protected function setComment($comment)
    {
        $this->comment = $comment;
    }
}
