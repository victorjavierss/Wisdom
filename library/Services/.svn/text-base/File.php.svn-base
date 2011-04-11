<?php
/**
 * Wrapper para facilitar la lectura/escritura de archivos
 * @author vsanchez
 * @since 01/04/2010
 * @version 0.1 
 */
class Services_File{
	
	/**
	 * Recurso para la escritura/lectura de archivo
	 * @var resource 
	 */
	private $_file = NULL; 
	
	/**
	 * Cierra el archivo
	 */
	public function __destruct(){
		$this->close();
	}
	
	/**
	 * Crea la ruta necesaria despues de FILES_PATH
	 * @param $path la ruta
	 */
	private function _dir($path){
		
		$path = preg_replace('/(\.\.)+/','',$path);
		$path = preg_replace( '/(\/\/)+/','/',$path  );
		if( strpos($path,'/') === 0 ){
			$path = substr($path,1,-1);
		}
		
		
	  	$real_path = APP_HOME . DIRECTORY_SEPARATOR . FILES_PATH. DIRECTORY_SEPARATOR . $path;
	  	
	  	
	    if( ! is_dir( $real_path ) ){
	    	$parent_path = dirname($real_path);
	    	if( is_writable($parent_path) ){
	    		mkdir($real_path,0775);
	    	}else {
	    		throw new Exception("Path $parent_path is not writable for make dir $path");
	    	}
	    }else{
	     	if( ! is_writable($real_path)){
	     		throw new Exception("Path $path is not writable");
	     	}else {
	     		#Se puede escribir en el directorio
	     	}
	    }
	    return $real_path.DIRECTORY_SEPARATOR;
	}
	
	/**
	 * Crea o abre el archivo para su lectura/escritura
	 * @param unknown_type $filename
	 * @param unknown_type $flags
	 */
	private function _initFile($filename, $flags){
		if( $flags == 'w+' && ! is_readable($filename) ){
			throw new Exception('File '. basename($filename) . 'is not redeable');
        }
		$this->_file = fopen($filename, $flags);		  	
	}
	
	/**
	 * Abre el archivo
	 * @param $filename Nombre del archivo
	 * @param $path Ruta del archivo
	 * @param $flags 
	 */
	private function _open($filename, $path='.', $flags){
		$path = (!is_string($path)) ? '.' : $path;
		if ( is_string($path) && is_string($filename)  ){
	        $filename = $this->_dir($path) . $filename;
		  	$this->_initFile($filename, $flags);
		  }else{
		  	throw new Exception("Wrong name or path for file service");
		  }
	}
	
	public function openForRead($filename, $path='.'){
		$this->_open($filename,$path,'r');
	}
	
	public function newFile($filename, $path='.'){
		$this->_open($filename,$path,'w');
	}
	
	public function openForWrite($filename, $path='.'){
		$this->_open($filename,$path,'a+');
	}
	
	public function read($length = 0){
		fseek($this->_file,0);
		return ($length == 0) ? fgets($this->_file) : fgets($this->_file,$length);
	}
	
	public function write($content){
	  fwrite($this->_file,$content);
	}
	
	public function close(){
		if ( is_resource($this->_file) )
			fclose($this->_file);
	}
}
