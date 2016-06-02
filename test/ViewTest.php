<?php

use PHPLegends\View\View;
use PHPLegends\View\Factory;

class ViewTest extends PHPUnit_Framework_TestCase
{

    protected function view($name, $data = [])
    {   
        return new View($name, $data, __DIR__ . '/views/');
    }

    public function testViewAndData()
    {

        $data = new ArrayObject(['class' => 'View']);

        $view = $this->view('home/index.phtml', $data);

        $this->assertEquals(__DIR__ . '/views', $view->getBasePath());

        $this->assertEquals('PHPLegends\View\View', $view->render());

        $data['class'] = 'Section';

        $this->assertEquals('PHPLegends\View\Section', $view->render());

    }

    public function testSection()
    {
        $view = $this->view('home/section.phtml');

        $view->render();

        $this->assertEquals(
            'Testing Section', trim($view->getSection('content'))
        );

        $this->assertEquals(
            '\PHPLegends\View\Section', (string) $view->getSection('_debug')
        );

    }

    public function testExtend()
    {
        $view = $this->view('home/child.phtml');

        $this->assertEquals(
            'I am parent and my child is Maxters', $view->render()
        );

    }

}