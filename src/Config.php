<?php

namespace PHPLegends\View;

/**
 * @TODO não sei se vou usar, não quero complicar demais
 * */

class Config
{ 

    const NAMESPACE_SEPARATOR = ':';

    /**
    * List of available namespaces
    * @var array
    */
	protected $namespaces = [];

    /**
     * @var string
     * */
    protected $extension = '.php';


    /**
    * Path of views
    * @var string|null
    */
    protected $path = null;

    /**
    * Registrer an namespace for a directory of views
    * @param string $namespace
    * @param string $directory
    * @return \PHPLegends\Legendary\ViewConfig
    */
    public function registerNamespace($namespace, $directory)
    {
    	$this->namespaces[$namespace] = rtrim($directory, '/') . '/';

        return $this;
    }

    /**
    * Registre a group of namespaces by array
    * @param array $namespaces
    * @return \PHPLegends\Legendary\ViewConfig
    */
    public function registerNamespaces(array $namespaces)
    {
    	foreach ($namespaces as $namespace => $path) {

            $this->registerNamespace($namespace, $path);
        }

        return $this;
    }

    /**
    * Defines the extension of php view
    * @param string $extension
    * @return \PHPLegends\Legendary\ViewConfig
    */
    public function setExtension($extension)
    {
    	$this->extension = $extension;

        return $this;
    }

    /**
    * Parse view name to given fullpath of a view
    * @access protected
    * @param string view
    * @return string
    */
    protected function parseViewName($view)
    {
        if (strpos($view, static::NAMESPACE_SEPARATOR) === false) {

            return $this->buildpath($view);
        }

        list($namespace, $basename) = explode(static::NAMESPACE_SEPARATOR, $view);

        if (! isset($this->namespaces[$namespace])) {

            throw new \UnexpectedValueException(
                "The namespace '$namespace' is not defined"
            );
        }

        return $this->buildpath($this->namespaces[$namespace] . $basename);
    }

    /**
    * Create namespace 
    * @param string $namespace
    * @return bool
    */
    public function namespaceExists($namespace)
    {
        return isset($this->namespaces[$namespace]);
    }

    /**
    * Builds the name of view path
    * @access protected
    * @param string|null $view 
    * @return string
    */
    protected function buildpath($view = null)
    {
        return $this->path . $view . $this->extension;
    }

    /**
    * Defines the path of view
    * @param string $path
    * @return \PHPLegends\Legendary\ViewConfig
    */
    public function setPath($path)
    {
        $this->path = rtrim($path, '/') . '/';

        return $this;
    }


    public static function createDefault()
    {
        $config = new ViewConfig();
    }
 }
