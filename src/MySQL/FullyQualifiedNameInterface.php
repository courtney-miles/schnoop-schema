<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL;

interface FullyQualifiedNameInterface
{
    /**
     * Indicates if the DDL will use the fully qualified name for the table.
     *
     * @return bool
     */
    public function useFullyQualifiedName();

    /**
     * Set if the DDL should use the fully qualified name for the table.
     *
     * @param bool $useFullyQualifiedName
     */
    public function setUseFullyQualifiedName($useFullyQualifiedName);
}
