<?php

namespace PHPLegends\View;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/

class Section
{   
    /**
    * Contents of Section
    * @var string
    */
    protected $content = '';

    /**
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
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @param string $content
     * 
     * @return \PHPLegends\View\Section
    */
    public function setContent($content)
    {
        $this->content = (string) $content;

        return $this;
    }

    /**
    * Appends string in current section
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
    * Starts the output buffer capturing in current section]
    * @return void
    */
    public function start()
    {
        ob_start();

        $this->counter++;

        $this->closed = ($this->counter === 0);

    }

    /**
    * Close the output buffer capturing
    * @return void
    */
    public function end()
    {
        if ($this->isClosed())
        {
            throw new \RuntimeException("The section {$this->name} already closed.");
        }

        $this->appendContent(ob_get_clean());

        $this->counter--;

        $this->closed = ($this->counter === 0);
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

    public function __destruct()
    {
        if (! $this->isClosed())
        {
            throw new \RuntimeException("The section {$this->name} must be closed");
        }
    }

    /**
     * Check if is closed
     * 
     * @return boolean
     * */
    public function isClosed()
    {
        return $this->closed;
    }

}