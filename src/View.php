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
    protected $parentView;

    /**
     * @var \PHPLegends\View\SectionCollection
     * */
    protected $sections;

    /**
     * @var string
     * */
    protected $extension = 'php';

    /**
     * @var string
     * */
    protected $basepath;

    /**
     * @param string $name
     * @param ArrayObject|array $data
     * @param string|null $basepath
     * @param string|null $extension
     * @return void
     * */
    public function __construct ($name, $data = [], $basepath = null, $extension = null)
    {
        $this->setName($name);

        $this->resolveDataValue($data);

        $basepath && $this->setPath($basepath);

        $extension && $this->setExtension($extension);

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
     * Gets the real filename
     * @return string
     * */
    public function buildFilename()
    {
        $filename = $this->getBasepath() . '/' . $this->getName() . '.' . $this->getExtension();

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
    * @param string $name
    * @return void
    */
    public function startSection($name, $content = null)
    {
        $section = new Section($name);

        $this->sections->attach($section);

        $content ? $section->setContent($content) : $section->start();

    }

    /**
    * Alias for startSection
    * @param string $name
    * @param string $default
    * @return string
    */
    public function section($name, $content = null)
    {
        return $this->startSection($name, $content);
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

        if ($this->sections->has($name)) {

            return $this->sections->get($name);
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
    * @param string $name
    * @param array $data
    * @return void
    */
    public function extend($name, $data = [], $basepath = null, $extension = null)
    {
        $basepath ?: $basepath = $this->basepath;

        $extension ?: $extension = $this->extension;

        $this->parentView = new static($name, $data, $basepath, $extension);
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
     * @param mixed $extension the extension
     *
     * @return self
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
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
     * @param string $name
     * @param string|null $content
     * @return void
     * */
    public function appendSection($name, $content = null)
    {
        $section = $this->sections->findOrCreate($name);

        $content ? $section->appendContent($content) : $section->start();
    }

}