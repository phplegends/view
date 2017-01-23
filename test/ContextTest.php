<?php

use PHPLegends\View\Finder;
use PHPLegends\View\Context;
use PHPLegends\View\Factory;

class ContextText extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->context = new Context(new Factory(new Finder));
    }

    public function testMultipleSectionStart()
    {
       $this->context->section('content');
       
       $this->context->section('metatag');

       $this->context->appendSection('metatag');

       $this->context->endSection();

       $this->context->endSection();

       $this->context->endSection();
    }
}