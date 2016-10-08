<?php

namespace MilesAsylum\SchnoopSchema\MySQL;

interface HasDelimiterInterface
{
    const DEFAULT_DELIMITER = ';';

    /**
     * Get the delimiter to use between statements.
     * @return string
     */
    public function getDelimiter();

    /**
     * Set the delimiter to use between statements.
     * @param string $delimiter
     */
    public function setDelimiter($delimiter);
}
