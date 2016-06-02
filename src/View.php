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
     * @var string
     * */
    protected $basepath;

    /**
     * @param string $filename
     * @param ArrayObject|array $data
     * @param string|null $basepath
     * @param string|null $extension
     * @return void
     * */
    
    public function __construct ($filename, $data = [], $basepath = null)
    {
        $this->setFilename($filename);

        $this->resolveDataValue($data);

        $basepath && $this->setPath($basepath);

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

        throw new \InvalidArgumentException("Data must be ArrayObject or array value");
    }

    /**
    * Set filename for view
    * @param string $filename
    * @return \PHPLegends\Legendary\View
    */
    public function setFilename($filename)
    {
        $this->name = $filename;

        return $this;
    }

    /**
    * Get filename used by current view
    * @return string
    */
    public function getFilename()
    {
        return $this->name;
    }

    /**
     * Gets the real filename
     * @return string
     * */
    public function buildFilename()
    {
        $filename = $this->getFilename();

        $basepath = $this->getBasepath();

        $basepath && $filename = $basepath . '/' . $filename;
        
        if (! file_exists($filename))
        {   
            throw new \RuntimeException("file '$filename' doesn't exists");
        }

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

            if ($this->parentView) {

                require $this->parentView->buildFilename();
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
    * @return void
    */
    public function setSectionCollection(SectionCollection $sections)
    {
        $this->sections = $sections;
    }

    /**
    * Extends the current view with a parent view. The data too is shared.
    * @param string $filename
    * @param array $data
    * @return void
    */
    public function extend($filename, $data = [], $basepath = null)
    {
        $basepath ?: $basepath = $this->basepath;

        $this->parentView = new static($filename, $data, $basepath);
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
     * Gets the value of path.
     *
     * @return string
     */
    public function getBasepath()
    {
        return $this->basepath;
    }

    /**
     * Sets the value of path.
     *
     * @param string $basepath
     *
     * @return self
     */
    public function setPath($basepath)
    {
        $this->basepath = rtrim($basepath, '/');

        return $this;
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

}