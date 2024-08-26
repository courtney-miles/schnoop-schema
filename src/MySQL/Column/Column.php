<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Column;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\NumericTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TimeTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\Exception\LogicException;

class Column implements ColumnInterface
{
    /**
     * The name of the column.
     *
     * @var string
     */
    protected $name;

    /**
     * The data type of the column.
     *
     * @var DataTypeInterface
     */
    protected $dataType;

    /**
     * The name of the table the column belongs to.
     */
    protected $tableName;

    /**
     * The name of the database the column belongs to.
     *
     * @var string
     */
    protected $databaseName;

    /**
     * Indicates if the column accepts NULL values.
     *
     * @var bool
     */
    protected $nullable = false;

    /**
     * The default value for the column.
     */
    protected $default;

    /**
     * Indicates if the column value should be set to the current time on update.
     *
     * @var bool
     */
    protected $onUpdateCurrentTimestamp = false;

    /**
     * The comment for the column.
     *
     * @var string
     */
    protected $comment;

    /**
     * @var bool
     */
    protected $autoIncrement;

    /**
     * Column constructor.
     *
     * @param string $name the name of the column
     * @param DataTypeInterface $dataType the data type of the column
     */
    public function __construct($name, DataTypeInterface $dataType)
    {
        $this->name = $name;
        $this->dataType = $dataType;

        if ($this->dataType instanceof NumericTypeInterface) {
            $this->autoIncrement = false;
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setTableName($tableName): void
    {
        $this->tableName = $tableName;
    }

    public function hasTableName()
    {
        return isset($this->tableName);
    }

    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    public function setDatabaseName($databaseName): void
    {
        $this->databaseName = $databaseName;
    }

    public function hasDatabaseName()
    {
        return isset($this->databaseName);
    }

    public function getDataType()
    {
        return $this->dataType;
    }

    public function isNullable()
    {
        return $this->nullable;
    }

    public function setNullable($nullable): void
    {
        $this->nullable = $nullable;
    }

    public function hasDefault()
    {
        if (!$this->getDataType()->doesAllowDefault()) {
            return false;
        }

        return null !== $this->default || $this->isNullable();
    }

    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @throws LogicException exception when setting a default value when the
     *                        data type does not support it
     */
    public function setDefault($default): void
    {
        if (null !== $default && !$this->getDataType()->doesAllowDefault()) {
            throw new LogicException(sprintf('Unable to set default value for the column. The data-type "%s" does not support a default.', $this->getDataType()->getType()));
        }

        if (is_array($default)) {
            foreach ($default as $k => $v) {
                $default[$k] = $this->getDataType()->cast($v);
            }
        } elseif (null !== $default) {
            if (!($this->getDataType() instanceof TimeTypeInterface)) {
                $default = $this->getDataType()->cast($default);
            }
        }

        $this->default = $default;
    }

    public function unsetDefault(): void
    {
        $this->default = null;
    }

    public function isOnUpdateCurrentTimestamp()
    {
        return $this->onUpdateCurrentTimestamp;
    }

    /**
     * @throws LogicException exception when setting this property when the
     *                        data type does not support it
     */
    public function setOnUpdateCurrentTimestamp($onUpdateCurrentTimestamp): void
    {
        if (!empty($onUpdateCurrentTimestamp) && !($this->dataType instanceof TimeTypeInterface)) {
            throw new LogicException(sprintf('Data type "%s" for column "%s" does not support setting current time on update.', $this->dataType->getType(), $this->name));
        }

        $this->onUpdateCurrentTimestamp = $onUpdateCurrentTimestamp;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function hasComment()
    {
        return null !== $this->comment && '' !== $this->comment;
    }

    public function setComment($comment): void
    {
        $this->comment = null !== $comment && '' !== $comment ? $comment : null;
    }

    public function unsetComment(): void
    {
        $this->comment = '';
    }

    public function isAutoIncrement()
    {
        return $this->autoIncrement;
    }

    /**
     * @throws LogicException exception when setting this property when the
     *                        data type does not support it
     */
    public function setAutoIncrement($autoIncrement): void
    {
        if ($autoIncrement && !($this->dataType instanceof NumericTypeInterface)) {
            throw new LogicException(sprintf('Unable to set auto-increment property on the column. Data-type "%s" does not support an auto-incrementing value.', $this->getDataType()->getType()));
        }

        $this->autoIncrement = $autoIncrement;
    }

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
                    (string) $this->getDataType(),
                    $this->nullable ? 'NULL' : 'NOT NULL',
                    $this->hasDefault() ? 'DEFAULT ' . $default : null,
                    $this->isOnUpdateCurrentTimestamp() ? $this->createOnUpdateCurrentTimestampDDL() : null,
                    $this->isAutoIncrement() ? 'AUTO_INCREMENT' : null,
                    $this->hasComment() ? sprintf("COMMENT '%s'", addslashes($this->getComment())) : null,
                ]
            )
        );
    }

    public function __toString()
    {
        return $this->getDDL();
    }

    /**
     * Creates the portion of DDL for the column default value.
     *
     * @return string DDL portion for the column default
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
            && self::DEFAULT_CURRENT_TIMESTAMP == $this->getDefault()
        ) {
            $precision = $dataType->hasPrecision() ? '(' . $dataType->getPrecision() . ')' : null;
            $default = self::DEFAULT_CURRENT_TIMESTAMP . $precision;
        } else {
            $default = null === $this->getDefault() ? 'NULL' : $this->getDataType()->quote($default);
        }

        return $default;
    }

    /**
     * Creates the portion of DDL for setting column value to the current
     * time on update.
     *
     * @return string|null DDL portion for setting column value to the current
     *                     time. NULL if the column is not set to have the value set on update.
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
