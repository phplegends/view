<?php

namespace PHPLegends\View;

interface FinderInterface
{

    /**
     * 
     * @param string $view
     * @return string
     * @throws PHPLegends\Views\Exceptions\ViewNotFoundException
     * */
    public function find($view);

}