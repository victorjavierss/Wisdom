<?php
class Services_Xml{

	private $_xml;

	public function __construct($file = NULL){
		$this->open($file);	
	}

	private function open($file){
		if( is_file($file) ){
			$this->_xml = simplexml_load_file($file);	
		}else{
			throw new Exception( "File [{$file}] doesn't exists" );
		}
	}

	public function __get($tag){
		return $this->_xml->$tag->__toString();
	}
}