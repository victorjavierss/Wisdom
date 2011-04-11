<?php
abstract class Logger_Observer implements SplObserver{
	
	private $_id = NULL;
	
	public function __construct(){
		$this->_id = mt_rand(1,2000);
	}
	
	public function getID(){
		return $this->_id;
	}
}