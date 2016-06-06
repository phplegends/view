<?php

namespace PHPLegends\View;

use PHPLegends\Collections\Collection;

class Data extends Collection
{	
	protected $protected = [];

	public function protect($key)
	{
		$this->protected[] = $key;
	}

	public function isProtected($key)
	{
		return in_array($key, $this->protected, true);
	}

	public function define($key, $value)
	{
		parent::set($key, $value);

		$this->protect($key);

		return $this;
	}

	public function delete($key)
	{
		if ($this->isProtected($key)) {

			throw new \RunTimeException("Cannot delete protected '$key' item");
		}

		return parent::delete($key);
	}

	public function set($key, $value)
	{
		if ($this->isProtected($key)) {

			throw new \RunTimeException("Cannot set value in protected '$key' item");
		}

		return parent::set($key, $value);
	}

	public function merge(array $data, $recursive = false)
	{
		$this->checkForProtected($data);

		return parent::merge($data, $recursive);
	}

	public function setItems(array $items)
	{
		$this->checkForProtected($items);

		return parent::setItems($items);
	}

	protected function checkForProtected(array $data)
	{
		foreach (array_keys($data) as $key) {

			if ($this->isProtected($key)) {

				throw new \RunTimeException("Cannot set value in protected '$key' index");
			}
		}
	}
}
