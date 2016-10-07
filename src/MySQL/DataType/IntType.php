<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 18/06/16
 * Time: 11:25 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class IntType extends AbstractIntType
{
    const MIN_SIGNED = -2147483648;
    const MIN_UNSIGNED = 0;
    const MAX_SIGNED = 2147483647;
    const MAX_UNSIGNED = 4294967295;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_INT;
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
