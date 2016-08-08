<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 8/07/16
 * Time: 7:30 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait OptionTrait
{
    protected $options = [];
    
    public function getOptions()
    {
        return $this->options;
    }
    
    protected function setOptions(array $options)
    {
        $this->options = $options;
    }
}