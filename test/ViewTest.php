<?php

use PHPLegends\View\View;

class ViewTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {

        $data = new ArrayObject(['class' => 'View']);

        $view = new View(__DIR__ . '/views/index', $data);

        $this->assertEquals('PHPLegends\View\View', $view->render());

        $data['class'] = 'Section';

        $this->assertEquals('PHPLegends\View\Section', $view->render());

    }
}