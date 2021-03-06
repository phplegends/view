<?php

namespace PHPLegends\View;

use PHPLegends\Collections\Collection;

/**
 * Represents the view data
 * 
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
 * */
class Data extends Collection
{   
    /**
     * 
     * @var array
     * */
    protected $protected = [];

    /**
     * Protects a index in data for block deletes and sets
     * 
     * @param string $key
     * @return self
     * */
    public function protect($key)
    {
        $this->protected[] = $key;

        return $this;
    }

    /**
     * Checks if value is protected
     * 
     * @param string $key
     * @return boolean
     * */
    public function isProtected($key)
    {
        return in_array($key, $this->protected, true);
    }

    /**
     * Defines a protected value for data
     * 
     * @param string $key
     * @param mixed $value
     * @return self
     * @throws \UnexpectedValueException
     * */
    public function define($key, $value)
    {

        if ($this->isProtected($key)) {

            throw new \UnexpectedValueException("Cannot re-assing protected '$key' item");
        }

        parent::set($key, $value);

        $this->protect($key);

        return $this;
    }

    /**
     * Overwrites delete method. Checking if protected are added
     * 
     * @param string $key
     * @return self
     * @throws \RunTimeException
     * */
    public function delete($key)
    {
        if ($this->isProtected($key)) {

            throw new \UnexpectedValueException("Cannot delete protected '$key' item");
        }

        return parent::delete($key);
    }

    /**
     * Overwrites delete method. Check if procteded are added
     * 
     * @param string $key
     * @param mixed $value
     * @return self
     * @throws \UnexpectedValueException
     * */
    public function set($key, $value)
    {
        if ($this->isProtected($key)) {

            throw new \UnexpectedValueException("Cannot set value in protected '$key' item");
        }

        return parent::set($key, $value);
    }

    /**
     * Overwrites merge method. Check if procteded are added
     * 
     * 
     * @param array $items
     * @param boolean $recursive
     * @return self
     * */
    public function merge(array $items, $recursive = false)
    {
        foreach ($items as $key => $value)
        {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * 
     * Overwrites delete method. Check if procteded are added
     * 
     * @param array $items
     * @return self
     * */
    public function setItems(array $items)
    {
        $this->checkForProtected($items);

        return parent::setItems($items);
    }
    
    /**
     * Verify if data is protected. If true, Exception is throwed
     * 
     * @param array $data
     * @return void
     * @throws \UnexpectedValueException
     * */
    protected function checkForProtected(array $data)
    {
        foreach (array_keys($data) as $key) {

            if ($this->isProtected($key)) {

                throw new \UnexpectedValueException("Cannot set value in protected '$key' index");
            }
        }
    }
}
