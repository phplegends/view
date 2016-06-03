<?php

use PHPLegends\View\View;
use PHPLegends\View\Factory;

class ViewTest extends PHPUnit_Framework_TestCase
{

    protected function view($name, $data = [])
    {   
        $factory = function ($name, $data = []) use(&$factory) {

            $view = new View(__DIR__ . '/views/' . $name, $data);

            $view->setFactory($factory);

            return $view;

        };

        return $factory($name, $data);
    }

    public function testViewAndData()
    {

        $data = new ArrayObject(['class' => 'View']);

        $view = $this->view('home/index.phtml', $data);

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