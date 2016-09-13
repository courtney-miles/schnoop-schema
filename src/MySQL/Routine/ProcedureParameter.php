<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

class ProcedureParameter extends AbstractRoutineParameter implements ProcedureParameterInterface
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
