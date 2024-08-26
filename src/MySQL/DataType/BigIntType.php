<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class BigIntType extends AbstractIntType
{
    public const MIN_SIGNED = -9223372036854775808;
    public const MAX_SIGNED = 9223372036854775807;
    public const MIN_UNSIGNED = 0;
    public const MAX_UNSIGNED = 18446744073709551615;

    public function getType()
    {
        return self::TYPE_BIGINT;
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
