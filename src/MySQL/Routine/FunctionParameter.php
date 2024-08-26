<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

class FunctionParameter extends AbstractRoutineParameter implements FunctionParameterInterface
{
    public function getDDL()
    {
        return sprintf(
            '`%s` %s',
            $this->getName(),
            (string) $this->getDataType()
        );
    }

    public function __toString()
    {
        return $this->getDDL();
    }
}
