<?php

use PHPLegends\View\Finder;

use PHPLegends\View\Context;
use PHPLegends\View\Factory;


class FactoryTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->factory = new Factory(new Finder);

		$finder = $this->factory->getFinder();

		$finder->addExtension('phtml');

		$finder->setDefaultPath(__DIR__ . '/views/');
	}

	public function testCreate()
	{
		$view = $this->factory->create('home/parent');

		echo $view->render();
	}
}
