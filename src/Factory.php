<?php

namespace PHPLegends\View;

class Factory
{

    protected $basepath;

    protected $extension;

    /**
     * 
     * 
     * */
    protected $pathAliases = [];

    /**
     * Constructor
     * 
     * @param string $basepath
     * @param string $extension
     * */
    public function __construct($basepath, $extension = 'php')
    {
        $this->basepath = $basepath;

        $this->extension = $extension;
    }

    /**
     * Creates a view
     * 
     * @param string $view 
     * @param array $data
     * @return PHPLegends\View\View
     * */
    public function create($view, $data = [])
    {
        return new View($this->buildFilename($view), $data);
    }

    /**
     * Build the filename of view
     * 
     * @param string $view
     * @return string
     * */
    protected function buildFilename($view)
    {
        $filename = $this->parsePathAlias($view) . '.' . $this->extension;

        if ($this->basepath)
        {
            $filename = $this->basepath . '/' . $filename;
        }

        return $filename;
    }

    /**
     * Creates a view instance
     * 
     * @param string $view
     * @param array $data
     * @return PHPLegends\View\View
     * */
    public function __invoke($view, $data = [])
    {
        return $this->create($view, $data);
    }

    /**
     * Set an alias path
     * 
     * @param string $alias
     * @param string $path
     * @return self
     * */
    public function setPathAlias($alias, $path)
    {
        $this->pathAliases[$alias] = $path;

        return $this;
    }

    /**
     * Gets path alias
     * 
     * @param string $alias
     * @return string
     * */
    public function getPathAlias($alias)
    {
        if (! isset($this->pathAliases[$alias]))
        {
            throw new \InvalidArgumentException(
                "The alias '$alias' is not defined"
            );
        }

        return $this->pathAliases[$alias];
    }

    /**
     * Parse path according to alias.
     * 
     * @param string $path
     * @return string
     * */
    protected function parsePathAlias($path)
    {
        if (strpos($path, ':') === false)
        {
            return $path;
        }

        list($alias, $end) = explode(':', $path, 2);

        return $this->getPathAlias($alias) . '/' . ltrim($end, '/');
    }
}