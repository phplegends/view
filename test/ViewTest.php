<?php

use PHPLegends\View\View;

class ViewTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {   
        View::setPath(__DIR__);

        View::setExtension('phtml');
    }

    public function test()
    {

        $data = new ArrayObject(['class' => 'View']);

        $view = new View('views/index', $data);

        $this->assertEquals('PHPLegends\View\View', $view->render());

        $data['class'] = 'Section';

        $this->assertEquals('PHPLegends\View\Section', $view->render());

    }

    public function testSection()
    {
        $view = new View('views/section');

        $view->render();

        $this->assertEquals(
            'Testing Section', trim($view->getSection('content'))
        );


        var_dump($view->getSection('_debug'));
    }

}