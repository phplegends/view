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
    protected $name;

    /**
     * @var \PHPLegends\View\View
     * */
    protected $extendedView;

    /**
     * @var \PHPLegends\View\SectionCollection
     * */
    protected $sections;

    /**
     * @var string
     * */
    protected static $extension = 'php';

    /**
     * @var string
     * */
    protected static $path;

    public function __construct ($name, $data = [], SectionCollection $section = null)
    {
        $this->setName($name);

        $this->resolveDataValue($data);

        if (! file_exists($filename = $this->buildFilename()))
        {   
            throw new \RuntimeException("file '$filename' doesn't exists");
        }

        $this->setSectionsCollection(
            $section ? $section : new SectionCollection
        );

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
     * @return void
     * */
    public function setData(\ArrayObject $data)
    {
        $this->data = $data;
    }

    /**
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

        throw new \InvalidArgumentException("Data must be ArrayObject, PHPLegends\View\Data or array value");
    }

    /**
    * Set filename for view
    * @param string $name
    * @return \PHPLegends\Legendary\View
    */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
    * Get filename used by current view
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * */
    public function buildFilename()
    {
        $filename = sprintf(
            '%s/%s.%s',
            static::$path, 
            ltrim($this->getName(), '/'),
            static::$extension
        );

        return $filename;
    }

    /**
    * Get view renderized
    * @return string
    */
    public function render()
    {
        ob_start();

        try {

            extract($this->getData()->getArrayCopy());

            require $this->buildFilename();

            if ($this->extendedView) {

                require $this->extendedView->getName();
            }

        } catch (\Exception $e) {

            $this->handleException($e);
        }

        return ltrim(ob_get_clean());

    }

    /**
    * Starts a section
    * @param string $name
    * @return void
    */
    public function startSection($name)
    {
        $section = $this->sections->findOrCreate($name);

        $section->start();
    }

    /**
    * Alias for startSection
    * @param string $name
    * @param string $default
    * @return string
    */
    public function section($name)
    {
        return $this->startSection($name);
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
    * @param string $name
    * @param string $default
    * @return string
    */
    public function getSection($name, $default = '')
    {
        $section = $this->sections->get($name);

        if ($section instanceof Section) {

            return $section->getContent();
        }

        return $default;
    }

    /**
    * Gets the collection of sections
    * @return \PHPLegends\Legendary\SectionCollection
    */
    public function getSectionsCollection()
    {
        return $this->sections;
    }

    /**
    * Sets a new collection of section in current view
    * @param \PHPLegends\Legendary\SectionCollection $sections
    * @return void
    */
    public function setSectionsCollection(SectionCollection $sections)
    {
        $this->sections = $sections;
    }

    /**
    * Extends the current view with a parent view. The data too is shared.
    * @param string $name
    * @param array $data
    * @return void
    */
    public function extend($name, $data = [])
    {
        $this->extendedView = new static($name, $data);
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
    * returns strings using the method static::render()
    * @return string
    */
    public function __toString() 
    {
        return $this->render();
    }

    /**
     * @param string $extension
     * @return void
     * */

    public static function setExtension($extension)
    {
        static::$extension = $extension;
    }

    /**
     * @param string $path
     * @return void
     * */

    public static function setPath($path)
    {
        static::$path = $path;
    }

    /**
     * Gets the value of extension.
     *
     * @return string
     */
    public static function getExtension()
    {
        return static::$extension;
    }


    /**
     * Gets the value of paths.
     *
     * @return string
     */
    public static function getPath()
    {
        return static::$path;
    }

}