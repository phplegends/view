<?php

namespace PHPLegends\View;

/**
 * The section of view.
 * 
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/
class Section
{   
    /**
     * Contents of Section
     * 
     * @var string
    */
    protected $content = '';

    /**
     * @deprecated since 2017-01-23. Use "counter === 0" insteadof
     * @var boolean
    */
    protected $closed = true;

    /**
     * @var string
    */
    protected $name;

    /**
     * 
     * @var int
     * */
    protected $counter = 0;

    /**
    * @param string $name
    */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
    * Defines the name of section
    * @param string $name
    * @return \PHPLegends\View\Section
    */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the name of section
     * 
     * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the content
     * 
     * @param string $content
     * @return \PHPLegends\View\Section
    */
    public function setContent($content)
    {
        $this->content = (string) $content;

        return $this;
    }

    /**
     * Appends string in current section
     * 
     * @param string $content
     * @return \PHPLegends\View\Section
    */
    public function appendContent($content)
    {
        $this->content .= $content;

        return $this;
    }

    /**
    * Returns the content of current section
    * @return string
    */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Starts the output buffer capturing in current section
     * 
     * @return void
    */
    public function start()
    {
        ob_start();

        $this->counter++;   

        /**
         * @deprecated
         * */
        $this->closed = $this->isClosed(); 
    }

    /**
     * Close the output buffer capturing
     *
     * @return void
    */
    public function end()
    {
        if ($this->getCounter() === 0)
        {
            throw new \RuntimeException("The section {$this->name} already closed.");
        }

        $this->appendContent(ob_get_clean());

        $this->counter--;

        /**
         * @deprecated
        */
        $this->closed = $this->isClosed();
    }

    /**
     * Returns the static::getContents()
     * 
     * @return \PHPLegends\View\Section
    */
    public function __toString()
    {
        return $this->getContent();
    }

    /**
     *
     * @throws RunTimeException on not completely closed section
     * */
    public function __destruct()
    {
        if ($this->getCounter() > 0)
        {
            throw new \RuntimeException("The section {$this->name} must be closed");
        }
    }

    /**
     * Check if is closed
     * 
     * @deprecated since 2017-01-23. Use "static::getCounter() === 0" instead of
     * @return boolean
     * */
    public function isClosed()
    {
        return $this->counter === 0;
    }

    /**
     * Returns the number of times the session was started.
     * 
     * @return int
     * */
    public function getCounter()
    {
        return $this->counter;
    }
}