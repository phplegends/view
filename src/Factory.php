<?php

namespace PHPLegends\View;

/**
 * Create a factory for views
 * 
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
 * 
 * */

class Factory implements FactoryInterface
{   

    /**
     * @var PHPLegends\View\FinderInterface
     * */
    protected $finder;

    /**
     * 
     * @var PHPLegends\View\Data
     * */
    protected $data;

    /**
     * 
     * @param PHPLegends\View\FinderInterface $finder
     * @param PHPLegends\View\Data | null $data
     * 
     * */
    public function __construct(FinderInterface $finder, Data $data = null)
    {
        $this->finder = $finder;

        $this->data = $data;
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
        $filename = $this->getFinder()->find($view);

        $this->getData()->merge($data);

        return new View($filename, $this->getData(), new Context($this));
    }   

    /**
     * 
     * @return PHPLegends\View\Finder
     * */
    public function getFinder()
    {
        return $this->finder;
    }

    /**
     * 
     * @return PHPLegends\View\Data
     * 
     * */
    public function getData()
    {
        return $this->data ?: $this->data = new Data();
    }

    /**
     * 
     * @param string $name
     * @param string $value
     * @return self
     * */
    public function share($name, $value)
    {
        $this->getData()->set($name, $value);

        return $this;
    }

        

}