<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class SmallIntType extends AbstractIntType
{
    public const MIN_SIGNED = -32768;
    public const MAX_SIGNED = 32767;
    public const MIN_UNSIGNED = 0;
    public const MAX_UNSIGNED = 65535;

    public function getType()
    {
        return self::TYPE_SMALLINT;
    }

    public function getMinRange()
    {
        return $this->isSigned() ? self::MIN_SIGNED : self::MIN_UNSIGNED;
    }

    public function getMaxRange()
    {
        return $this->isSigned() ? self::MAX_SIGNED : self::MAX_UNSIGNED;
    }
}
