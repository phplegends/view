<?php

namespace PHPLegends\View;

class Context
{

	protected $factory;

	protected $parentView;

	protected $sections;

	public function __construct(FactoryInterface $factory)
	{
		$this->factory = $factory;
	}
	/**
	 * Sets the parent view
	 * 
	 * @param View $view
	 * @return self
	 * */
	public function setParentView(View $view)
	{
		$this->parentView = $view;

		return $this;
	}

	/**
     * Gets the value of parentView.
     *
     * @return mixed
     */
    public function getParentView()
    {
        return $this->parentView;
    }

	/**
	 * 
	 * @param string $name
	 * @param array $data
	 * @return self
	 * */
	public function extend($name, $data = [])
	{
		$parent = $this->factory->create($name, $data);

		return $this->setParentView($parent);
	}


	/**
	* Starts a section. If content is passed, section doesn't not use "blocks"
	* 
	* @param string $filename
	* @param string|null $content
	* @return void
	*/
	public function startSection($filename, $content = null)
	{
	    $section = new Section($filename);

	    $this->getSectionCollection()->attach($section);

	    $content ? $section->setContent($content) : $section->start();

	    return $this;
	}

	/**
	 * Alias for startSection
	 * 
	 * @param string $filename
	 * @param string $default
	 * @return self
	*/
	public function section($filename, $content = null)
	{
	    return $this->startSection($filename, $content);
	}

	/**
	* Ends a section
	* 
	* @return void
	*/
	public function endSection()
	{
	    $section = $this->getSectionCollection()->last();

	    if (! $section) {

	        throw new \RuntimeException('closeSection called without start a section');
	    }

	    $section->end();
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
	    $section = $this->getSectionCollection()->findOrCreate($filename);

	    $content ? $section->appendContent($content) : $section->start();
	}

	/**
	* Gives the value of a initialized section
	* @param string $filename
	* @param string $default
	* @return string
	*/
	public function getSection($name, $default = '')
	{

	    if ($this->getSectionCollection()->has($name)) {

	        return $this->getSectionCollection()->get($name);
	    }

	    return $default;
	}

	/**
	* Gets the collection of sections
	* @return \PHPLegends\Legendary\SectionCollection
	*/
	public function getSectionCollection()
	{
	    return $this->sections ?: $this->sections = new SectionCollection;
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
     * Gets the value of factory.
     *
     * @return PHPLegends\View\FactoryInterface
     */
    public function getFactory()
    {
        return $this->factory;
    }


    /**
     * Sets the value of factory.
     *
     * @param FactoryInterface $factory the factory
     *
     * @return self
     */
    public function setFactory(FactoryInterface $factory)
    {
        $this->factory = $factory;

        return $this;
    }
}