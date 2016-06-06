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

    /**
     * 
     * @param string $name
     * @param string $path
     * */
    public function setPathAlias($name, $path);

    /**
     * 
     * @param string $name
     * @return string
     * @throws \InvalidArgumentException
     * */
    public function getPathAlias($name);

    /**
     * 
     * @param string $name
     * @param string|null $preprocessor
     * */
    public function addExtension($extension, $preprocessor = null);

    /**
     * 
     * @return array
     * */

    public function getExtensions();

    /**
     * 
     * @param string $path
     * */

    public function setDefaultPath($path);

    /**
     * @return string
     * */

    public function getDefaultPath();

}