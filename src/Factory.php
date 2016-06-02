<?php

namespace PHPLegends\View;

class Factory
{

    public function __construct($path, $extension = 'php')
    {
        $this->path = $path;

        $this->extension = $extension;
    }

    public function create($view, $data = [])
    {
        return new View($this->buildFilename($view), $data, $this->path);
    }

    protected function buildFilename($view)
    {
        return $view . '.' . $this->extension;
    }
}