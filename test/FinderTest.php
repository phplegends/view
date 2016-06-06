<?php

use PHPLegends\View\Finder;

class FinderTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->finder = new Finder();

		$this->finder->addExtension('tpl');

		$this->finder->addExtension('phtml');

		$this->finder->setPathAlias('home', __DIR__ . '/views/home/');
	}

	public function testPossibleFiles()
	{
		$files = $this->finder->getPossibleFiles('home:child');

		$this->assertCount(2, $files);

		$this->assertStringEndsWith('child.phtml', $files->last()['filename']);
	}

	public function testGetPathAlias()
	{
		$path = $this->finder->getPathAlias('home');

		// Last '/' are removed internally

		$this->assertEquals(__DIR__ . '/views/home', $path);
	}

	public function testGetExistingFile()
	{
		$file = $this->finder->find('home:child');

		$this->assertEquals(__DIR__ . '/views/home/child.phtml', $file);
	}


}