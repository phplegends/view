<?php

use PHPLegends\View\Factory;

class FactoryTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $factory = new Factory(__DIR__ . '/views/', 'phtml');

        $view = $factory->create('home/index');

        $this->assertInstanceof(
            'PHPLegends\View\View',
            $view
        );
    }
}