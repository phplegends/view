<?php

namespace PHPLegends\View;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/
class View
{

    /**
     * @var \ArrayObject
     * */
    protected $data;

    /**
     * @var string
     * */
    protected $filename;

    /**
     * @var \PHPLegends\View\View
     * */
    protected $parentView;

    /**
     * @var \PHPLegends\View\SectionCollection
     * */
    protected $sections;

    /**
     * 
     * @var callable
     * */
    protected $factory;

    /**
     * @param string $filename
     * @param ArrayObject|array $data
     * @return void
     * */
    
    public function __construct ($filename, $data = [])
    {
        $this->setFilename($filename);

        $this->resolveDataValue($data);

        $this->setSectionCollection(new SectionCollection);

    }

    /**
    * Get data passed to view
    * @return \ArrayObject
    */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param PHPLegends\View\Data $data
     * @return self
     * */
    public function setData(\ArrayObject $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     *
     * 
     * @param \ArrayObject | array $data
     * @throws \InvalidArgumentException
     * @return void
     * */

    public function resolveDataValue($data)
    {
        if ($data instanceof \ArrayObject) {

            return $this->setData($data);

        } elseif (is_array($data)) {

            return $this->setData(new \ArrayObject($data));
        }

        throw new \InvalidArgumentException(
            "Data must be ArrayObject or array value"
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

        if (! file_exists($filename)) {
            throw new \UnexpectedValueException(
                "The file '$filename' doesn't not exists"
            );
        }

        $this->filename = $filename;

        return $this;
    }

    /**
    * Get filename used by current view
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
        ob_start();

        try {

            extract($this->getData()->getArrayCopy());

            require $this->getFilename();

            if ($this->parentView) {

                require $this->parentView->getFilename();
            }

        } catch (\Exception $e) {

            return $this->handleException($e);
        }

        return ltrim(ob_get_clean());

    }

    /**
    * Starts a section. If content is passed, section doesn't not use "blocks"
    * @param string $filename
    * @return void
    */
    public function startSection($filename, $content = null)
    {
        $section = new Section($filename);

        $this->sections->attach($section);

        $content ? $section->setContent($content) : $section->start();

    }

    /**
    * Alias for startSection
    * @param string $filename
    * @param string $default
    * @return string
    */
    public function section($filename, $content = null)
    {
        return $this->startSection($filename, $content);
    }

    /**
    * Ends a section
    * @return void
    */
    public function endSection()
    {
        $section = $this->sections->last();

        if (! $section) {

            throw new \RuntimeException('closeSection called without start a section');
        }

        $section->end();
    }
    
    /**
    * Gives the value of a initialized section
    * @param string $filename
    * @param string $default
    * @return string
    */
    public function getSection($filename, $default = '')
    {

        if ($this->sections->has($filename)) {

            return $this->sections->get($filename);
        }

        return $default;
    }

    /**
    * Gets the collection of sections
    * @return \PHPLegends\Legendary\SectionCollection
    */
    public function getSectionCollection()
    {
        return $this->sections;
    }

    /**
    * Sets a new collection of section in current view
    * @param \PHPLegends\Legendary\SectionCollection $sections
    * @return self
    */
    public function setSectionCollection(SectionCollection $sections)
    {
        $this->sections = $sections;

        return $this;
    }

    /**
    * Extends the current view with a parent view. The data too is shared.
    * 
    * 
    * @return void
    */
    public function extend()
    {
        $this->parentView = $this->callFactory(func_get_args());

        return $this->parentView;
    }

    /**
    * Handles the Exception
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
     * Append in a section. If content is passed, section doesn't not use "blocks"
     * 
     * @param string $filename
     * @param string|null $content
     * @return void
     * */
    public function appendSection($filename, $content = null)
    {
        $section = $this->sections->findOrCreate($filename);

        $content ? $section->appendContent($content) : $section->start();
    }


    /**
     * Gets the factory of view
     * 
     * @return callable (Closure or __invoke implementation)
     * */

    public function getFactory()
    {
        if ($this->factory === null) {

            $class = get_class($this);

            $this->factory = function ($name, $data = []) use ($class) {
                return new $class($name, $data);
            };
        }

        return $this->factory;
    }

    public function setFactory($factory)
    {
        if (is_object($factory) && method_exists($factory, '__invoke'))
        {
            $this->factory = $factory;

            return $this;
        }

        throw new \InvalidArgumentException(
            "The factory must be a object with implementention of __invoke "
        );
    }

    /**
     * 
     * @param array $arguments
     * @return PHPLegends\View\View
     * */
    public function callFactory(array $arguments)
    {
        $result = call_user_func_array($this->getFactory(), $arguments);

        if (! $result instanceof self) {

            $message = sprintf(
                'The factory must be return "%s" instance, "%s" given',
                get_class($this),
                is_object($result) ? get_class($result) : gettype($result)
            );

            throw new \UnexpectedValueException($message);
        }

        return $result;
    }

    /**
     * Include a view in 
     * 
     * @param ... $arguments
     * */
    public function load()
    {
        return $this->callFactory(func_get_args());
    }

}