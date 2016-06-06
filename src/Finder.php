<?php

namespace PHPLegends\View;

use PHPLegends\Collections\Collection;
use PHPLegends\View\Exceptions\ViewNotFoundException;

class Finder implements FinderInterface
{
	protected $pathAliases = [];

	protected $extensions;

	protected $defaultPath;

	public function __construct(array $extensions = [], $defaultPath = null)
	{
		$this->extensions = new Collection;

        $this->addExtensions($extensions);

        $this->defaultPath = $defaultPath;

	}

	public function find($name)
	{
		$data = $this->getPossibleFiles($name)->first(function ($data) {
			return file_exists($data['filename']);
		});

		if ($data === null) {
			
			throw new ViewNotFoundException(sprintf('View "%s" not found', $name));
		}

        extract($data);

        if ($preprocessor)  {

            $preprocessor = new $preprocessor($filename);

            $filename = $preprocessor->getFilename();
        }

		return $filename;
	}

    /**
     * Gets the value of pathAliases.
     *
     * @return mixed
     */
    public function getPathAliases()
    {
        return $this->pathAliases;
    }

    /**
     * Sets sthe value of pathAliases.
     *
     * @param mixed $pathAliases the path aliases
     *
     * @return self
     */
    public function setPathAliases(array $pathAliases)
    {
        $this->pathAliases = $pathAliases;

        return $this;
    }

    /**
     * Gets the value of pathAlias.
     * 
     * @param string $alias
     * @return string
     */
    public function getPathAlias($alias)
    {
    	if (! isset($this->pathAliases[$alias]))
    	{
    		throw new \InvalidArgumentException("Alias \"{$alias}\" is not defined");
    	}

        return $this->pathAliases[$alias];
    }

    /**
     * Sets the value of pathAlias.
     *
     * @param mixed $pathAlias the path alias
     *
     * @return self
     */
    public function setPathAlias($alias, $path)
    {
        $this->pathAliases[$alias] = rtrim($path, '/');

        return $this;
    }

    protected function getPartOfPathByAlias($path)
    {
    	if (strpos($path, ':') === false)
    	{
    		return $this->getDefaultPath() . '/' . $path;
    	}

    	list($alias, $end) = explode(':', $path, 2);

    	return $this->getPathAlias($alias) . '/' . $end;
    }

    /**
     * 
     * 
     * @param string  $paths
     * 
     * */
    public function getPossibleFiles($path)
    {
    	$path = $this->getPartOfPathByAlias($path);

    	return $this->extensions->map(function ($preprocessor, $extension) use($path) {

    		$filename = $path . '.' . $extension;

            return compact('filename', 'preprocessor');

    	});
    }

    /**
     * 
     * @param string $extension
     * @param string $preprocessor
     * @return self
     * */
    public function addExtension($extension, $preprocessor = null)
    {

        if (! $this->isValidPreProcessorValue($preprocessor))
        {
            throw new \InvalidArgumentException("{$preprocessor} must be implement PHPLegends\\View\\PreProcessorInterface");
        }   

    	$this->extensions[$extension] = $preprocessor;

    	return $this;
    }

    public function addExtensions(array $data)
    {
        foreach ($data as $extension => $preprocessor) {

            $this->addExtension($extension, $preprocessor);
        }

        return $this;
    }

    protected function isValidPreProcessorValue($class)
    {
        return $class === null || is_subclass_of($class, 'PHPLegends\\View\\PreProcessorInterface', true);
    }

    /**
     * 
     * @return Collection
     * */
    public function getExtensions()
    {
    	return $this->extensions;
    }

    /**
     * 
     * 
     * @param string $path
     * @return self
     * */
    public function setDefaultPath($path)
    {
    	$this->defaultPath = $path;

    	return $this;
    }

    public function getDefaultPath()
    {
    	return $this->defaultPath;
    }

}