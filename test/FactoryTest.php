<?php

use PHPLegends\View\Data;
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

	public function testContextWithInclude()
	{
		$view = $this->factory->create('home/include');

		$view->render(); // or called on View cast to string

		$this->assertTrue($view->hasContext());

		$this->assertTrue($view->getContext()->hasParentView());

		$this->assertEquals(
			'Wallace Maxters', 
			$view->getContext()->getSectionCollection()->get('child')->getContent()
		);

	}

	public function testToString()
	{
		$view = $this->factory->create('home/child');

		$this->assertTrue(method_exists($view, '__toString'));
	}

	public function testDataWhenArrayPassed()
	{
		// Teste with Array

		$this->factory->share('global', 'this is global');

		$view = $this->factory->create('home/child', ['age' => 25]);

		$view['name'] = 'Wallace';

		$this->assertEquals('Wallace', $view['name']);

		$this->assertEquals('Wallace', $view->getData()->get('name'));

		$this->assertEquals(25, $view['age']);

		$this->assertEquals('this is global', $view['global']);

	}

	public function testDataWhenDataObjectPassed()
	{
		$data = new Data(['age' => 18]);

		$this->factory->share('global', 'i am global baby');

		$view = $this->factory->create('home/child', $data);

		$view['name'] = 'Wayne';

		$this->assertEquals('Wayne', $view['name']);

		$this->assertEquals('Wayne', $view->getData()->get('name'));

		$this->assertEquals(18, $view['age']);

		$this->assertEquals('i am global baby', $view['global']);
	}


}
