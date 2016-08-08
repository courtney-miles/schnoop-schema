<?php

namespace MilesAsylum\SchnoopSchema;

use MilesAsylum\SchnoopSchema\Exception\ColumnException;

/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 2/06/16
 * Time: 7:30 AM
 */
abstract class AbstractColumn implements ColumnInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var DataTypeInterface
     */
    protected $dataType;

    /**
     * @var TableInterface
     */
    protected $table;

    /**
     * AbstractColumn constructor.
     * @param string $name
     * @param DataTypeInterface $dataType
     */
    public function __construct($name, DataTypeInterface $dataType)
    {
        $this->setName($name);
        $this->setDataType($dataType);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return DataTypeInterface
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @param mixed $name
     */
    protected function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param DataTypeInterface $dataType
     */
    protected function setDataType(DataTypeInterface $dataType)
    {
        $this->dataType = $dataType;
    }

    public function setTable(TableInterface $table)
    {
        if (isset($this->table)) {
            throw new ColumnException(
                sprintf(
                    'Attempt made to attach column %s to table %s when it is already attached to %s',
                    $this->getName(),
                    $table->getName(),
                    $this->table->getName()
                )
            );
        }

        $this->table = $table;
    }
}