<?php

namespace PHPLegends\View;

interface PreprocessorInterface
{	

    /**
     * 
     * @return string
     * */
	public function getOutputFilename();

    /**
     * 
     * 
     * @param string $filename
     * @return self
     * */
    public function setInputFilename($filename);

    /**
     * Run the preprocessor
     * 
     * */
    public function run();
}