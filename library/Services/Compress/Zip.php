<?php
class Services_Compress_Zip extends Compress_Compressor{
	
	protected function init($filename){
		$this->_handler = new ZipArchive();
		
		if ($this->_handler->open($filename,ZIPARCHIVE::CREATE)!==TRUE){
			throw new Exception('Could not Open Zip File: {$filename} ');
		}
		
	}
	
	public function close(){
		if ( is_a($this->_handler,'ZipArchive') ){
			$this->_handler->close();
		}		
	}
	
	public function addEmptyDir($path){
		$this->_handler->addEmptyDir($path);
	}
	
	public function addFile($file,$zip_name){
		return $this->_handler->addFile($file,$zip_name);
	}
	
	
	public function extract($destination,$files = NULL){
		
	}
	
}
