<?php

namespace PHPLegends\View;

/**
 * Interfaces to preprocess a view
 * 
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
 * */
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