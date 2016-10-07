<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

interface IndexedColumnInterface extends ConstraintColumnInterface
{
    /**
     * MySQL keyword for ascending index collation.
     */
    const COLLATION_ASC = 'ASC';

    /**
     * Get the index prefix length.
     * @return int Index prefix length.
     */
    public function getLength();

    /**
     * Identify if length is set for the index.
     * @return bool
     */
    public function hasLength();

    /**
     * Set the prefix length for the index.
     * @param int $length Prefix length.
     */
    public function setLength($length);

    /**
     * Get the collation for the index.
     * @return string One of self::COLLATION_* constants.
     */
    public function getCollation();

    /**
     * Set the collation for the index.
     * @param string $collation One of self::COLLATION_* constants.
     */
    public function setCollation($collation);

    /**
     * Identify if collation is set for the index.
     * @return bool
     */
    public function hasCollation();
}
