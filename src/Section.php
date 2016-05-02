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
    protected $started = false;


    /**
    * @var boolean
    */

    protected $closed = true;

    protected $name;

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
    * @return \PHPLegends\Legendary\Section
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
    * @param string $content
    * @return \PHPLegends\Legendary\Section
    */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
    * Appends string in current section
    * @param string $content
    * @return \PHPLegends\Legendary\Section
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
    * Append output buffer in current section
    * @return \PHPLegends\Legendary\Section
    */
    public function append()
    {
        $this->appendContent(ob_get_clean());

        return $this;
    }

    /**
    * Starts the output buffer capturing in current section]
    * @return void
    */
    public function start()
    {
        if ($this->started) return;

        ob_start();

        $this->started = true;

        $this->closed = false;      
    }

    /**
    * Close the output buffer capturing
    * @return void
    */
    public function end()
    {

        if (! $this->started) return;

        $this->setContent(ob_get_clean());

        $this->closed = true;
    }

    /**
    * Returns the static::getContents()
    * @return \PHPLegends\Legendary\Section
    */
    public function __toString()
    {
        return $this->getContent();
    }
}