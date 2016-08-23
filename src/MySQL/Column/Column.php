<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Column;

use MilesAsylum\SchnoopSchema\AbstractColumn;
use MilesAsylum\SchnoopSchema\Exception\ColumnException;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\NumericTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface;

class Column implements ColumnInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var DataTypeInterface
     */
    protected $dataType;

    protected $tableName;

    /**
     * @var bool
     */
    protected $nullable = false;

    /**
     * @var mixed
     */
    protected $default;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var bool
     */
    protected $zeroFill;

    /**
     * @var bool
     */
    protected $autoIncrement;

    public function __construct($name, DataTypeInterface $dataType)
    {
        $this->name = $name;
        $this->dataType = $dataType;

        if ($this->dataType instanceof NumericTypeInterface) {
            $this->zeroFill = false;
            $this->autoIncrement = false;
        }
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    public function hasTableName()
    {
        return isset($this->tableName);
    }

    /**
     * @return DataTypeInterface
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @return boolean
     */
    public function isNullable()
    {
        return $this->nullable;
    }

    public function setNullable($nullable)
    {
        $this->nullable = $nullable;
    }

    public function hasDefault()
    {
        if (!$this->getDataType()->doesAllowDefault()) {
            return false;
        }

        return $this->default !== null || $this->isNullable();
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function setDefault($default)
    {
        if ($default !== null && !$this->getDataType()->doesAllowDefault()) {
            trigger_error(
                'Unable to set default value for the column as the data-type does not support a default.',
                E_USER_WARNING
            );

            $default = null;
        }

        if (is_array($default)) {
            foreach ($default as $k => $v) {
                $default[$k] = $this->getDataType()->cast($v);
            }
        } elseif ($default !== null) {
            $default = $this->getDataType()->cast($default);
        }

        $this->default = $default;
    }

    /**
     * @return string
     */
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

    /**
     * @return boolean|null
     */
    public function isZeroFill()
    {
        return $this->zeroFill;
    }

    public function setZeroFill($zeroFill)
    {
        if ($zeroFill && !($this->dataType instanceof NumericTypeInterface)) {
            trigger_error(
                "Unable to set zero-fill property on the column as its data-type does not support it.",
                E_USER_WARNING
            );

            $zeroFill = false;
        }

        $this->zeroFill = $zeroFill;
    }

    /**
     * @return boolean|null
     */
    public function isAutoIncrement()
    {
        return $this->autoIncrement;
    }

    public function setAutoIncrement($autoIncrement)
    {
        if ($autoIncrement && !($this->dataType instanceof NumericTypeInterface)) {
            trigger_error(
                "Unable to set autoincrement property on the column as its data-type does not support it.",
                E_USER_WARNING
            );

            $autoIncrement = false;
        }

        $this->autoIncrement = $autoIncrement;
    }

    public function __toString()
    {
        $default = null;

        if ($this->hasDefault()) {
            $default = $this->prepareDDLDefault($this->getDefault());
        }

        return implode(
            ' ',
            array_filter(
                [
                    '`' . $this->getName() . '`',
                    (string)$this->getDataType(),
                    $this->isZeroFill() ? 'ZEROFILL' : null,
                    $this->nullable ? 'NULL' : 'NOT NULL',
                    $this->hasDefault() ? 'DEFAULT ' . $default : null,
                    $this->isAutoIncrement() ? 'AUTO_INCREMENT' : null,
                    $this->hasComment() ? sprintf("COMMENT '%s'", addslashes($this->getComment())) : null
                ]
            )
        );
    }

    protected function prepareDDLDefault($default)
    {
        if (is_array($default)) {
            foreach ($default as $k => $option) {
                $default[$k] = $this->getDataType()->quote($option);
            }
            $default = '(' . implode(',', $default) . ')';
        } else {
            $default = $this->getDefault() === null ? 'NULL' : $this->getDataType()->quote($default);
        }

        return $default;
    }
}
