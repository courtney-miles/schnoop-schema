<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class SetType extends AbstractOptionsType
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_SET;
    }

    /**
     * {@inheritdoc}
     */
    public function cast($value)
    {
        if (!empty($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = parent::cast($v);
            }
        }

        return $value;
    }
}
