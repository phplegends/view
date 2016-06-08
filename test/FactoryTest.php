<?php

use PHPLegends\View\Finder;

use PHPLegends\View\Context;
use PHPLegends\View\Factory;


class FactoryTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$finder = new Finder;

		$finder->addExtension('phtml');

		$finder->setDefaultPath(__DIR__ . '/views/');

		$this->factory = new Factory($finder);
	}

	public function testFilename()
	{
		$view = $this->factory->create('home/parent');

		$this->assertStringEndsWith('parent.phtml', $view->getFilename());
	}

	public function testContext()
	{
		$view = $this->factory->create('home/child');

		$view->render();

		$this->assertTrue($view->hasContext());

		$this->assertTrue($view->getContext()->hasParentView());

	}

	public function testToString()
	{
		$view = $this->factory->create('home/child');

		$this->assertTrue(method_exists($view, '__toString'));
	}

	public function testData()
	{
		$view = $this->factory->create('home/child');

		$view['name'] = 'Wallace';

		$this->assertEquals('Wallace', $view['name']);

		$this->assertEquals('Wallace', $view->getData()->get('name'));
	}
}
