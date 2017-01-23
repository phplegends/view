<?php

use PHPLegends\View\Finder;
use PHPLegends\View\Context;
use PHPLegends\View\Factory;

class ContextTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->context = new Context(new Factory(new Finder()));
    }

    public function testMultipleSection()
    {
        $this->context->section('content');

        $this->context->section('metatags');

        $this->assertFalse(
            $this->context->getSectionCollection()->get('content')->isClosed()
        );

        $this->assertFalse(
            $this->context->getSectionCollection()->get('metatags')->isClosed()
        );

        $this->context->section('title', 'My simple title'); // no need "endSection"

        $this->context->endSection();

        $this->context->endSection();

        $this->assertTrue(
            $this->context->getSectionCollection()->get('content')->isClosed()
        );

        $this->assertTrue(
            $this->context->getSectionCollection()->get('metatags')->isClosed()
        );

        $this->assertTrue(
            $this->context->getSectionCollection()->get('title')->isClosed()
        );

    }


    public function testMultipleSectionWithAppendSection() 
    {
        $this->context->section('content');
        $this->context->section('metatags');
        $this->context->appendSection('metatags');
        $this->context->endSection();
        $this->context->endSection();
        $this->context->endSection();
    }
}