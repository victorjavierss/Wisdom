<?php
class Services_Compress{
	
	private $_formats             = array ('zip'=>'Services_Compress_Zip');
	private $_compression_manager = NULL;
	private $_base_dir            = FALSE;
	
		
	public function open($file, $force = FALSE, $new = FALSE, $relative = TRUE){
		if ($relative){
			$file = APP_HOME . '/files/' . $file;
		}
		if ( ! $new && ! is_file($file) ){
			throw new Exception("The file '{$file}' was not found");
		}
		
		$class = $this->_getClass($filem, $force);
		if ($class){
			$this->_compression_manager = Utils::accesor()->get($class,array($file));
		}else{
			throw new Exception('Could not determinate the class type of: ' . $file);
		}
		
	}

	
	protected function _addDir($path){
		
		if ( ! $this->_base_dir ){
			$this->_base_dir  = dirname($path);
		}
		 
	    $nodes = glob($path . '/*'); 
	    if ( is_array($nodes) ){
		    foreach ($nodes as $node) {
		        if (is_dir($node)) { 
		            $this->_addDir($node); 
		        } else if (is_file($node))  {
		        	$zip_name = str_replace($this->_base_dir,'',$node);
		        	$zip_name = substr($zip_name,1);
		            $this->_compression_manager->addFile($node,$zip_name); 
		        } 
		    } 	
	    }
	}
	
	protected function _addFile($file,$zip_name){
	  return $this->_compression_manager->addFile( $file, $zip_name );
	}
	
	public function append($path_file){
		$return = FALSE;
		if( is_dir($path_file) ){
		    $this->_addDir($path_file);
		}else if(is_file($path_file)) {
			if ( is_readable($path_file) ){ 
				$this->_addFile($path_file);
				$added = $this->_addFile($path_file);
			} else {
				throw new Exception ("{$path_file} is not readable");
			}
		} else {
			throw new Exception("{$path_file} is not a file or directory");
		}
		
		return $return;
	}
	
	/**
	 * @param $file
	 */
	
	private function _getClass($file, $force){
		$class = FALSE;

		if ($force){
			$class = isset($this->_formats[$force]) ? $this->_formats[$force] : FALSE;
		}else{
			foreach($this->_formats as $ext=>$format_class){
				if ( preg_match( "/.{$ext}$/" ,$file) ){
					$class = $format_class;
					break;
				}
			}
		}
		
		return $class;
	}
	
	public function getAviableFormats(){
		return array_keys($this->_formats);
	}
}
