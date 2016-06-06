<?php

namespace PHPLegends\View;

/**
 * Factory Interface for views
 * 
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
 *
*/
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