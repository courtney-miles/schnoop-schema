<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

interface IndexedColumnInterface extends ConstraintColumnInterface
{
    /**
     * MySQL keyword for ascending index collation.
     */
    public const COLLATION_ASC = 'ASC';

    /**
     * Get the index prefix length.
     *
     * @return int index prefix length
     */
    public function getLength();

    /**
     * Identify if length is set for the index.
     *
     * @return bool
     */
    public function hasLength();

    /**
     * Set the prefix length for the index.
     *
     * @param int $length prefix length
     */
    public function setLength($length);

    /**
     * Get the collation for the index.
     *
     * @return string one of self::COLLATION_* constants
     */
    public function getCollation();

    /**
     * Set the collation for the index.
     *
     * @param string $collation one of self::COLLATION_* constants
     */
    public function setCollation($collation);

    /**
     * Identify if collation is set for the index.
     *
     * @return bool
     */
    public function hasCollation();
}
