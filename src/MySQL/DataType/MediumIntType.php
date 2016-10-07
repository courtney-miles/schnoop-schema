<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class MediumIntType extends AbstractIntType
{
    const MIN_SIGNED = -8388608;
    const MAX_SIGNED = 8388607;
    const MIN_UNSIGNED = 0;
    const MAX_UNSIGNED = 16777215;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_MEDIUMINT;
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
