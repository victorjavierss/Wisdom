<?php
class Logger_Observer_File extends Logger_Observer{
	
	private $_filename = NULL;
	
    public function __construct($name){
    	$this->_filename = $name;
    	parent::__construct();
    }
	
	public function update( SplSubject $subject )
	{
		$log_status = $subject->getLogStatus();
		
		$file = Utils::Factory('Services')->File();

		$file->openForWrite($this->_filename.'.log','logs');

		$file->write( ">>  {$log_status['time']} :: {$log_status['message']} \n");
	}
	
}
