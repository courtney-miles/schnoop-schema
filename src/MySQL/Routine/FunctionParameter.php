<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

class FunctionParameter extends AbstractRoutineParameter implements FunctionParameterInterface
{
    public function __toString()
    {
        return sprintf(
            '`%s` %s',
            $this->getName(),
            (string)$this->getDataType()
        );
    }
}
