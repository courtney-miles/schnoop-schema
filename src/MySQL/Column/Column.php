<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Column;

use MilesAsylum\SchnoopSchema\MySQL\Exception\LogicException;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\NumericTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TimeTypeInterface;

class Column implements ColumnInterface
{
    /**
     * The name of the column.
     * @var string
     */
    protected $name;

    /**
     * The data type of the column.
     * @var DataTypeInterface
     */
    protected $dataType;

    /**
     * The name of the table the column belongs to.
     * @var
     */
    protected $tableName;

    /**
     * The name of the database the column belongs to.
     * @var string
     */
    protected $databaseName;

    /**
     * Indicates if the column accepts NULL values.
     * @var bool
     */
    protected $nullable = false;

    /**
     * The default value for the column.
     * @var mixed
     */
    protected $default;

    /**
     * Indicates if the column value should be set to the current time on update.
     * @var bool
     */
    protected $onUpdateCurrentTimestamp = false;

    /**
     * The comment for the column.
     * @var string
     */
    protected $comment;

    /**
     * @var bool
     */
    protected $autoIncrement;

    /**
     * Column constructor.
     * @param string $name The name of the column.
     * @param DataTypeInterface $dataType The data type of the column.
     */
    public function __construct($name, DataTypeInterface $dataType)
    {
        $this->name = $name;
        $this->dataType = $dataType;

        if ($this->dataType instanceof NumericTypeInterface) {
            $this->autoIncrement = false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * {@inheritdoc}
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * {@inheritdoc}
     */
    public function hasTableName()
    {
        return isset($this->tableName);
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * {@inheritdoc}
     */
    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDatabaseName()
    {
        return isset($this->databaseName);
    }

    /**
     * {@inheritdoc}
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * {@inheritdoc}
     */
    public function isNullable()
    {
        return $this->nullable;
    }

    /**
     * {@inheritdoc}
     */
    public function setNullable($nullable)
    {
        $this->nullable = $nullable;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDefault()
    {
        if (!$this->getDataType()->doesAllowDefault()) {
            return false;
        }

        return $this->default !== null || $this->isNullable();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * {@inheritdoc}
     * @throws LogicException Exception when setting a default value when the
     * data type does not support it.
     */
    public function setDefault($default)
    {
        if ($default !== null && !$this->getDataType()->doesAllowDefault()) {
            throw new LogicException(
                sprintf(
                    'Unable to set default value for the column. The data-type "%s" does not support a default.',
                    $this->getDataType()->getType()
                )
            );
        }

        if (is_array($default)) {
            foreach ($default as $k => $v) {
                $default[$k] = $this->getDataType()->cast($v);
            }
        } elseif ($default !== null) {
            if (!($this->getDataType() instanceof TimeTypeInterface)) {
                $default = $this->getDataType()->cast($default);
            }
        }

        $this->default = $default;
    }

    /**
     * {@inheritdoc}
     */
    public function unsetDefault()
    {
        $this->default = null;
    }

    /**
     * {@inheritdoc}
     */
    public function isOnUpdateCurrentTimestamp()
    {
        return $this->onUpdateCurrentTimestamp;
    }

    /**
     * {@inheritdoc}
     * @throws LogicException Exception when setting this property when the
     * data type does not support it.
     */
    public function setOnUpdateCurrentTimestamp($onUpdateCurrentTimestamp)
    {
        if (!empty($onUpdateCurrentTimestamp) && !($this->dataType instanceof TimeTypeInterface)) {
            throw new LogicException(
                sprintf(
                    'Data type "%s" for column "%s" does not support setting current time on update.',
                    $this->dataType->getType(),
                    $this->name
                )
            );
        }

        $this->onUpdateCurrentTimestamp = $onUpdateCurrentTimestamp;
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
        $this->comment = strlen($comment) ? (string)$comment : null;
    }

    /**
     * {@inheritdoc}
     */
    public function unsetComment()
    {
        $this->comment = '';
    }

    /**
     * {@inheritdoc}
     */
    public function isAutoIncrement()
    {
        return $this->autoIncrement;
    }

    /**
     * {@inheritdoc}
     * @throws LogicException Exception when setting this property when the
     * data type does not support it.
     */
    public function setAutoIncrement($autoIncrement)
    {
        if ($autoIncrement && !($this->dataType instanceof NumericTypeInterface)) {
            throw new LogicException(
                sprintf(
                    'Unable to set auto-increment property on the column. Data-type "%s" does not support an auto-incrementing value.',
                    $this->getDataType()->getType()
                )
            );
        }

        $this->autoIncrement = $autoIncrement;
    }

    /**
     * {@inheritdoc}
     */
    public function getDDL()
    {
        $default = null;

        if ($this->hasDefault()) {
            $default = $this->createDefaultDDL($this->getDefault());
        }

        return implode(
            ' ',
            array_filter(
                [
                    '`' . $this->getName() . '`',
                    (string)$this->getDataType(),
                    $this->nullable ? 'NULL' : 'NOT NULL',
                    $this->hasDefault() ? 'DEFAULT ' . $default : null,
                    $this->isOnUpdateCurrentTimestamp() ? $this->createOnUpdateCurrentTimestampDDL() : null,
                    $this->isAutoIncrement() ? 'AUTO_INCREMENT' : null,
                    $this->hasComment() ? sprintf("COMMENT '%s'", addslashes($this->getComment())) : null
                ]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getDDL();
    }

    /**
     * Creates the portion of DDL for the column default value.
     * @param mixed $default
     * @return string DDL portion for the column default.
     */
    protected function createDefaultDDL($default)
    {
        $dataType = $this->getDataType();

        if (is_array($default)) {
            foreach ($default as $k => $option) {
                $default[$k] = $this->getDataType()->quote($option);
            }
            $default = '(' . implode(',', $default) . ')';
        } elseif ($dataType instanceof TimeTypeInterface
            && $this->getDefault() == self::DEFAULT_CURRENT_TIMESTAMP
        ) {
            $precision = $dataType->hasPrecision() ? '(' . $dataType->getPrecision() . ')' : null;
            $default = self::DEFAULT_CURRENT_TIMESTAMP . $precision;
        } else {
            $default = $this->getDefault() === null ? 'NULL' : $this->getDataType()->quote($default);
        }

        return $default;
    }

    /**
     * Creates the portion of DDL for setting column value to the current
     * time on update.
     * @return null|string DDL portion for setting column value to the current
     * time. NULL if the column is not set to have the value set on update.
     */
    protected function createOnUpdateCurrentTimestampDDL()
    {
        $onUpdateDDL = null;

        $dataType = $this->getDataType();

        if ($this->isOnUpdateCurrentTimestamp()) {
            $precision = null;

            if ($dataType instanceof TimeTypeInterface && $dataType->hasPrecision()) {
                $precision = '(' . $dataType->getPrecision() . ')';
            }

            $onUpdateDDL = 'ON UPDATE CURRENT_TIMESTAMP' . $precision;
        }

        return $onUpdateDDL;
    }
}
