<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

class ProcedureParameter extends AbstractRoutineParameter implements ProcedureParameterInterface
{
    /**
     * Parameter value direction.
     *
     * @var string
     */
    protected $direction = self::DIRECTION_IN;

    /**
     * ProcedureParameter constructor.
     *
     * @param string $name parameter name
     * @param DataTypeInterface $dataType parameter data type
     * @param string $direction parameter value direction
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
    public function setDirection($direction): void
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
            (string) $this->getDataType()
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
