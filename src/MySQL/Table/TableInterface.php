<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 27/06/16
 * Time: 7:14 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\Table;

interface TableInterface extends \MilesAsylum\SchnoopSchema\TableInterface
{
    const ENGINE_INNODB = 'INNODB';
    const ENGINE_MEMORY = 'MEMORY';

    const ROW_FORMAT_DEFAULT = 'DEFAULT';
    const ROW_FORMAT_DYNAMIC = 'DYNAMIC';
    const ROW_FORMAT_FIXED = 'FIXED';
    const ROW_FORMAT_COMPRESSED = 'COMPRESSED';
    const ROW_FORMAT_REDUNDANT = 'REDUNDANT';
    const ROW_FORMAT_COMPACT = 'COMPACT';

    public function getEngine();

    public function hasEngine();

    public function getDefaultCollation();

    public function hasDefaultCollation();

    public function getRowFormat();

    public function hasRowFormat();
    
    public function getComment();

    public function hasComment();
}
