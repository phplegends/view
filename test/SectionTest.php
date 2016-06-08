<?php

use PHPLegends\View\Section;

class SectionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->section = new Section('__test__');
    }

    public function testGetName()
    {
        $this->assertEquals('__test__', $this->section->getName());
    }

    public function testSetName()
    {
        $this->section->setName('__other__');

        $this->assertEquals('__other__', $this->section->getName());

        $this->section->setName('__test__');
    }

    public function testIsClosed()
    {
        $this->assertTrue($this->section->isClosed());

        $this->section->start();

        $this->assertFalse($this->section->isClosed());

        $this->section->end();

        $this->assertTrue($this->section->isClosed());
    }
}