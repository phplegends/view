<?php

namespace PHPLegends\View;

interface PreprocessorInterface
{	
    /**
     * 
     * Sets the file to preprocess
     * @param string $filename
     * */
    public function setInputFilename($filename);

    /**
     * Run the preprocessor
     * 
     * */
    public function run();

    /**
     * Gets the output filename
     * 
     * @return string
     * */
	public function getOutputFilename();
}