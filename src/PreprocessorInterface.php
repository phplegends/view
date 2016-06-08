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
     * 
     * Gets the output file with preprocessor modifications
     * 
     * @return string
     * */
	public function getOutputFilename();
}