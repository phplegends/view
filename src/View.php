<?php

namespace PHPLegends\View;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/

class View implements \ArrayAccess
{

    /**
     * @var PHPLegends\View\Data
     * */
    protected $data;

    /**
     * @var string
     * */
    protected $filename;

    /**
     * 
     * @var Context
     * */
    protected $context;

    /**
     * @param string $filename
     * @param array| PHPLegends\View\Data $data
     * @param Context|null $context 
     * @return void
     * */
    
    public function __construct ($filename, $data = [], Context $context = null)
    {
        $this->setFilename($filename);

        $this->resolveDataValue($data);

        $this->context = $context;
    }

    /**
    * Get data passed to view
    * 
    * @return PHPLegends\View\Data
    */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets the Data
     * 
     * @param PHPLegends\View\Data $data
     * @return self
     * */
    public function setData(Data $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Resolves value for data
     * 
     * @param  \PHPLegends\View\Data | array $data
     * @throws \InvalidArgumentException
     * @return void
     * */

    public function resolveDataValue($data)
    {
        if ($data instanceof Data) {

            return $this->setData($data);

        } elseif (is_array($data)) {

            return $this->setData(new Data($data));
        }

        throw new \InvalidArgumentException(
            "Data must be View\Data or array value"
        );
    }

    /**
    * Set filename for view
    * 
    * @param string $filename
    * @return \PHPLegends\Legendary\View
    * @throws \UnexpectedValueException
    */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Gets filename used by current view
     * 
     * @return string
    */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Get view renderized
     *
     * @return string
    */
    public function render()
    {

        try {
            
            return $this->getContents();

        } catch (\Exception $e) {

            return $this->handleException($e);
        }

    }

    /**
     * Get the contents of View
     * 
     * @return string
     * */
    public function getContents()
    {
        ob_start();

        $callback = $this->hasContext() ? $this->getClosureForContextRender() : $this->callContextRender();

        call_user_func($callback, $this->getFilename(), $this->getData()->toArray());

        return ltrim(ob_get_clean());

    }

    /**
     * 
     * @return \Closure
     * 
     * */
    protected function getClosureForRender()
    {
        return function ($filename, $data) {
            
            extract(func_get_arg(1));

            require func_get_arg(0);
        };
    }

    /**
     * 
     * @return \Closure
     * */
    protected function getClosureForContextRender()
    {
        $callback = function ($filename, $data) {
            
            extract(func_get_arg(1));

            require func_get_arg(0);

            if ($this->getParentView()) {

                require $this->getParentView()->getFilename();
            }
        };

        return $callback->bindTo($this->getContext());
    }

    /**
    * Handles the Exception
    * s
    * @todo Guilherme, me ajude a melhorar o handler aqui :D
    * @return void
    */
    public function handleException(\Exception $exception)
    {
        while (ob_get_level() > 0) ob_get_clean();

        echo '<pre>', $exception, '</pre>';
    }

    /**
    * returns strings using the method self::render()
    * 
    * @return string
    */
    public function __toString() 
    {
        return $this->render();
    }

    /**
     * Gets the context or null
     * 
     * @return \PHPLegends\View\Context | null
     * */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Checks if view has context
     * 
     * @return boolean
     * 
     * */
    public function hasContext()
    {
        return $this->getContext() !== null;
    }

    /**
     * 
     * @param string $key
     * @param mixed $value
     * */
    public function offsetSet($key, $value)
    {
        $this->getData()->set($key, $value);
    }

    /**
     * 
     * @param string $key
     * */
    public function offsetGet($key)
    {
        return $this->getData()->getOrDefault($key);
    }

    /**
     * 
     * @param string $key
     * */
    public function offsetExists($key)
    {
        return $this->getData()->has($key);
    }

    /**
     * 
     * @param string $key
     * */
    public function offsetUnset($key)
    {
        $this->getData()->delete($key);
    }

}