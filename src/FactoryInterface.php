<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 4/06/16
 * Time: 8:38 AM
 */

namespace MilesAsylum\SchnoopSchema;

use MilesAsylum\Schnoop\Schnoop;

interface FactoryInterface
{
    /**
     * @param array $rawDatabase
     * @return DatabaseInterface
     */
    public function createDatabase(array $rawDatabase);

    /**
     * @param array $rawTable
     * @param array $rawColumns
     * @param array $rawIndexes
     * @return TableInterface
     */
    public function createTable(array $rawTable, array $rawColumns, array $rawIndexes);

    /**
     * @param array $rawColumn
     * @return ColumnInterface
     */
    public function createColumn(array $rawColumn);
}