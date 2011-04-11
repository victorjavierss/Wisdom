<?php
abstract class Services_Compress_Compressor implements Compress_Interface{

	private $_handler = NULL;
	
	public function __construct($filename){
		$this->init($filename);
	}
	
	public function __destruct(){
		$this->close();
	}
	
	protected abstract function init($filename);
}  
?>
