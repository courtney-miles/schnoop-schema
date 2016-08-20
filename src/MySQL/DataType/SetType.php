<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class SetType extends AbstractOptionsType
{
    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_SET;
    }

    /**
     * {@inheritdoc}
     * @param array $value
     * @return array
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
