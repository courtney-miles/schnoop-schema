<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

class ProcedureParameter extends AbstractRoutineParameter implements ProcedureParameterInterface
{
    protected $direction = self::DIRECTION_IN;

    public function __construct($name, DataTypeInterface $dataType, $direction = self::DIRECTION_IN)
    {
        parent::__construct($name, $dataType);

        $this->direction = $direction;
    }

    public function getDirection()
    {
        return $this->direction;
    }

    public function setDirection($direction)
    {
        $this->direction = $direction;
    }

    public function __toString()
    {
        return sprintf(
            '%s `%s` %s',
            $this->direction,
            $this->getName(),
            (string)$this->getDataType()
        );
    }
}
