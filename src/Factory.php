<?php

namespace PHPLegends\View;

class Factory implements FactoryInterface
{
    /**
     * 
     * @var string
     * */
    protected $basepath;

    /**
     * 
     * @var string
    */
    protected $extension;

    /**
     * 
     * @var string
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
        $view = new View($this->buildFilename($view), $data);

        $view->setSectionCollection(new SectionCollection);

        return $view;
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
     * Returns the path according to the alias.
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

    /**
     * Gets the value of basepath.
     *
     * @return string
     */
    public function getBasepath()
    {
        return $this->basepath;
    }

    /**
     * Sets the value of basepath.
     *
     * @param string $basepath the basepath
     *
     * @return self
     */
    public function setBasepath($basepath)
    {
        $this->basepath = $basepath;

        return $this;
    }

    /**
     * Gets the value of extension.
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Sets the value of extension.
     *
     * @param string $extension the extension
     *
     * @return self
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Gets the value of pathAliases.
     *
     * @return array
     */
    public function getPathAliases()
    {
        return $this->pathAliases;
    }

    /**
     * Sets the value of pathAliases.
     *
     * @param array $pathAliases the path aliases
     *
     * @return self
     */
    public function setPathAliases(array $pathAliases)
    {
        $this->pathAliases = $pathAliases;

        return $this;
    }
}