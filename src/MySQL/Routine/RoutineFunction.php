<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException;

class RoutineFunction extends AbstractRoutine implements RoutineFunctionInterface
{
    /**
     * Function parameters.
     * @var FunctionParameterInterface[]
     */
    protected $parameters = [];

    /**
     * Function return type.
     * @var DataTypeInterface
     */
    protected $returns;

    /**
     * RoutineFunction constructor.
     * @param string $name Function name.
     * @param DataTypeInterface $return Function return type.
     */
    public function __construct($name, DataTypeInterface $return)
    {
        parent::__construct($name);

        $this->returns = $return;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameters()
    {
        return !empty($this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function addParameter(FunctionParameterInterface $parameter)
    {
        $this->parameters[] = $parameter;
    }

    /**
     * {@inheritdoc}
     */
    public function getReturnType()
    {
        return $this->returns;
    }

    /**
     * {@inheritdoc}
     */
    public function setReturnType(DataTypeInterface $returns)
    {
        $this->returns = $returns;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreateStatement()
    {
        $dropDDL = $setSqlMode = $createDDL = $revertSqlMode = '';

        $functionName = $this->makeRoutineName();

        if ($this->dropPolicy) {
            switch ($this->dropPolicy) {
                case self::DDL_DROP_POLICY_DROP:
                    $dropDDL = <<<SQL
DROP FUNCTION {$functionName}{$this->delimiter}
SQL;
                    break;
                case self::DDL_DROP_POLICY_DROP_IF_EXISTS:
                    $dropDDL = <<<SQL
DROP FUNCTION IF EXISTS {$functionName}{$this->delimiter}
SQL;
                    break;
            }
        }

        if ($this->hasSqlMode()) {
            $prevDelimiter = $this->sqlMode->getDelimiter();
            $this->sqlMode->setDelimiter($this->delimiter);

            $setSqlMode = $this->sqlMode->getSetStatements();
            $revertSqlMode = $this->sqlMode->getRestoreStatements();

            $this->sqlMode->setDelimiter($prevDelimiter);
        }

        $functionSignature = "FUNCTION {$functionName} ({$this->makeParametersDDL()})";

        $createDDL .= 'CREATE ' . implode(
            "\n",
            array_filter(
                [
                    (!empty($this->definer)) ? 'DEFINER = ' . $this->definer : null,
                    $functionSignature,
                    'RETURNS ' . $this->returns->getDDL(),
                    $this->makeCharacteristicsDDL(),
                    'BEGIN',
                    $this->body,
                    'END' . $this->delimiter
                ]
            )
        );

        $createDDL = implode(
            "\n",
            array_filter(
                [
                    $setSqlMode,
                    $dropDDL,
                    $createDDL,
                    $revertSqlMode
                ]
            )
        );

        return $createDDL;
    }

    public function __toString()
    {
        return $this->getCreateStatement();
    }

    /**
     * Make the portion of DDL for describing the parameters.
     * @return string Parameters DDL.
     */
    protected function makeParametersDDL()
    {
        $params = [];

        foreach ($this->parameters as $parameter) {
            $params[] = $parameter->getDDL();
        }

        return implode(',', $params);
    }
}
