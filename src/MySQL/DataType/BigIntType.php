<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class BigIntType extends AbstractIntType
{
    const MIN_SIGNED = -9223372036854775808;
    const MAX_SIGNED = 9223372036854775807;
    const MIN_UNSIGNED = 0;
    const MAX_UNSIGNED = 18446744073709551615;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_BIGINT;
    }

    /**
     * {@inheritdoc}
     */
    public function getMinRange()
    {
        return $this->isSigned() ? self::MIN_SIGNED : self::MIN_UNSIGNED;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxRange()
    {
        return $this->isSigned() ? self::MAX_SIGNED : self::MAX_UNSIGNED;
    }
}
