<?php
namespace Plateau\Garage\Scripts;

/**
 * Data Structure For Volume Analysis
 */
class CheckerReport {
	
	public $total = 0;
	public $errorTotal = 0;

	public $errorMessages = array();

	public function addError(File $file, $message)
	{	
		$this->errorTotal++;

		$errorMessage = 'Volume '.$file->volume()->first()->label.' : '.$file->path.' - '.$message;

		$this->errorMessages[] = $errorMessage;
	}


	public function increments()
	{
		$this->total++;
	}



}