<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

class FunctionParameter extends AbstractRoutineParameter implements FunctionParameterInterface
{
    protected $direction = self::DIRECTION_IN;

    const DIRECTION_IN = 'IN';
    const DIRECTION_OUT = 'OUT';
    const DIRECTION_INOUT = 'INOUT';

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
