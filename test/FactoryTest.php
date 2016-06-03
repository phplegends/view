<?php

use PHPLegends\View\Factory;

class FactoryTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $factory = new Factory(__DIR__ . '/views/', 'phtml');

        $factory->setPathAlias('factory', 'home/testing/alias/for/view/factory');

        $view = $factory->create('factory:alias_test'); // or __invoke

        $this->assertInstanceof('PHPLegends\View\View', $view);
    }
}