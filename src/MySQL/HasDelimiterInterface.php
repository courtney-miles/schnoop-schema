<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL;

interface HasDelimiterInterface
{
    public const DEFAULT_DELIMITER = ';';

    /**
     * Get the delimiter to use between statements.
     *
     * @return string
     */
    public function getDelimiter();

    /**
     * Set the delimiter to use between statements.
     *
     * @param string $delimiter
     */
    public function setDelimiter($delimiter);
}
