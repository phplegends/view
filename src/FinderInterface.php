<?php

namespace PHPLegends\View;

/**
 * Finder interface for views
 * 
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
 * */
interface FinderInterface
{

    /**
     * Find the view
     * 
     * @param string $view
     * @return string
     * @throws PHPLegends\Views\Exceptions\ViewNotFoundException
     * */
    public function find($view);
}