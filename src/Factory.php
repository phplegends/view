<?php

namespace PHPLegends\View;

/**
 * Creates a Factory for Views.
 * 
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
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
     * @param array | PHPLegends\View\Data $data
     * @return PHPLegends\View\View
     * */
    public function create($view, $data = [])
    {
        $filename = $this->getFinder()->find($view);

        $mergeMethod = ($data instanceof Data) ? 'addAll' : 'merge';

        $this->getData()->$mergeMethod($data);

        return new View($filename, $this->getData(), new Context($this));
    }   

    /**
     * Gets the finder
     * 
     * @return PHPLegends\View\Finder
     * */
    public function getFinder()
    {
        return $this->finder;
    }

    /**
     * Gets the Data
     * 
     * @return PHPLegends\View\Data
     * */
    public function getData()
    {
        return $this->data ?: $this->data = new Data();
    }

    /**
     * Define an value in Factory Data instance. This is value will be shared with all created views
     * 
     * @param string $name
     * @param mixed $value
     * @return self
     * */
    public function share($name, $value)
    {
        $this->getData()->set($name, $value);

        return $this;
    }


    /**
     * Sets the value of finder.
     *
     * @param PHPLegends\View\FinderInterface $finder the finder
     *
     * @return self
     */
    protected function setFinder(FinderInterface $finder)
    {
        $this->finder = $finder;

        return $this;
    }

    /**
     * Sets the value of data.
     *
     * @param PHPLegends\View\Data $data the data
     *
     * @return self
     */
    public function setData(Data $data)
    {
        $this->data = $data;

        return $this;
    }
}