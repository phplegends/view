<?php

namespace PHPLegends\View;

interface FactoryInterface
{
    /**
     * Create new view instance 
     * 
     * @param string $filename
     * @param \ArrayObject | array $data
     * @return PHPLegends\View\View
     * */
    public function create($filename, $data = []);
}