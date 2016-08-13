<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 19/06/16
 * Time: 3:52 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\Column;

use MilesAsylum\SchnoopSchema\AbstractColumn;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\NumericTypeInterface;

/**
 * Class Column
 * @package MilesAsylum\SchnoopSchema\MySQL\Column
 * @method DataTypeInterface getDataType
 */
class Column extends AbstractColumn implements ColumnInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $allowNull;

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

    public function __construct(
        $name,
        DataTypeInterface $dataType,
        $allowNull,
        $default,
        $comment,
        $zeroFill = null,
        $autoIncrement = null
    ) {
        parent::__construct($name, $dataType);
        $this->allowNull = $allowNull;
        $this->setDefault($default);
        $this->comment = $comment;

        if ($this->dataType instanceof NumericTypeInterface) {
            $this->zeroFill = isset($zeroFill) ? (bool)$zeroFill : false;
            $this->autoIncrement = isset($autoIncrement) ? (bool)$autoIncrement : false;
        }
    }

    /**
     * @return boolean
     */
    public function doesAllowNull()
    {
        return $this->allowNull;
    }

    public function hasDefault()
    {
        if (!$this->getDataType()->doesAllowDefault()) {
            return false;
        }

        return $this->default !== null || $this->doesAllowNull();
    }

    public function getDefault()
    {
        return $this->default;
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

    protected function setDefault($default)
    {
        if ($default !== null && !$this->getDataType()->doesAllowDefault()) {
            trigger_error(
                'Attempt made to set a default value for a data-type that does not support a default. The supplied default value has been ignored.',
                E_USER_WARNING
            );
            
            $default = null;
        }

        $this->default = $default !== null ? $this->getDataType()->cast($default) : $default;
    }

    /**
     * @return boolean
     */
    public function doesZeroFill()
    {
        return $this->zeroFill;
    }

    /**
     * @return boolean
     */
    public function isAutoIncrement()
    {
        return $this->autoIncrement;
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
                    $this->doesZeroFill() ? 'ZEROFILL' : null,
                    $this->allowNull ? 'NULL' : 'NOT NULL',
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
