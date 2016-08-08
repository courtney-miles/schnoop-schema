<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 19/06/16
 * Time: 4:15 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\Column;

interface ColumnInterface extends \MilesAsylum\SchnoopSchema\ColumnInterface
{
    /**
     * @return boolean
     */
    public function doesAllowNull();

    /**
     * @return bool
     */
    public function hasDefault();

    /**
     * @return mixed
     */
    public function getDefault();

    /**
     * @return string
     */
    public function getComment();

    /**
     * @return bool|null Returns a boolean if the column is for a numeric data type, otherwise null.
     */
    public function doesZeroFill();

    /**
     * @return bool|null Returns a boolean if the column is for a numeric data type, otherwise null.
     */
    public function isAutoIncrement();
}