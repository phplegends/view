<?php

use PHPLegends\View\Data;

class DataTest extends PHPUnit_Framework_TestCase
{

	public function testDefine()
	{
		$data = new Data;

		$data->define('__name__', 'Internal name');

		$this->assertEquals($data->get('__name__'), 'Internal name');

		$this->assertTrue($data->isProtected('__name__'));


		//Not protected

		$data->set('name', 'Common name');

		$this->assertFalse($data->isProtected('name'));

	}

	public function testProtected()
	{
		$data =  new Data(['name' => 'Wallace', 'age' => 26]);

		$this->assertFalse($data->isProtected('name'));

		$data->protect('name');

		$this->assertTrue($data->isProtected('name'));

	}
}