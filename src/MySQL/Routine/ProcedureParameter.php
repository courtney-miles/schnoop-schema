<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

class ProcedureParameter extends AbstractRoutineParameter implements ProcedureParameterInterface
{
    /**
     * Parameter value direction.
     * @var string
     */
    protected $direction = self::DIRECTION_IN;

    /**
     * ProcedureParameter constructor.
     * @param string $name Parameter name.
     * @param DataTypeInterface $dataType Parameter data type.
     * @param string $direction Parameter value direction.
     */
    public function __construct($name, DataTypeInterface $dataType, $direction = self::DIRECTION_IN)
    {
        parent::__construct($name, $dataType);

        $this->direction = $direction;
    }

    /**
     * {@inheritdoc}
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * {@inheritdoc}
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
    }

    /**
     * {@inheritdoc}
     */
    public function getDDL()
    {
        return sprintf(
            '%s `%s` %s',
            $this->direction,
            $this->getName(),
            (string)$this->getDataType()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getDDL();
    }
}
