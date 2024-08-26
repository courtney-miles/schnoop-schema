<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class SetType extends AbstractOptionsType
{
    public function getType()
    {
        return self::TYPE_SET;
    }

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
