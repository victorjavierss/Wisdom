<?php
class Logger_Observer_Db extends Logger_Observer{
	
	private $_model = NULL;
	
	public function __construct(Model $model){
	    $this->_model = $model;
	}
	
	public function update( SplSubject $subject )
	{
		$log_status = $subject->getLogStatus();
		$this->_model->save($log_status);
	}
	
}