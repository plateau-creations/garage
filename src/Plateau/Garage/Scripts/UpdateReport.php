<?php
namespace Plateau\Garage\Scripts;


class UpdateReport {
	
	protected $messages = array();


	public function getMessages()
	{
		return $this->messages;
	}


	public function log($message)
	{
		$this->messages[] = $message;
	}

	
}