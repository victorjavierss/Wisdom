<?php
class Wisdom_Factory{

	static private $_cache  = array();

	public function get($classname, $params = array()){
		
		if( is_callable(array($classname,'getInstance')) ){
			$instance = call_user_func(array($classname,'getInstance'),$classname,$params);
		}else{
			
			if( is_string($params) ){
				$params = array($params);
			}elseif( ! is_array($params)){
				$params = array();
			}else{
				#Ya es un arreglo
			}
			
			if (class_exists($classname) ){
				if( count($params)>0 ){
					$reflection_class = new ReflectionClass($classname);
					if (is_object ($reflection_class->getConstructor ())) {
						$instance = $reflection_class->newInstanceArgs ($params);
					}else{
						throw new Exception('Could not instantiate the Object');
					}
				}else {
					$instance = new $classname ();
				}
			}else{
				throw new Exception("Class '{$classname}' doesn't exists");
			}
		}
		return $instance;
	}

	private function findClassFile($classname){
		
		$loaded_files = get_included_files();
		
		static $cache = array();
		
		if( array_key_exists($classname,$cache) ){
			$return = $cache[$classname];
		}else{
			$classname = str_replace('_', '\\'.DIRECTORY_SEPARATOR,$classname);
			$classname .= '.php';
			$return    = FALSE;
			
			$result = preg_grep("/.($classname)/i",$loaded_files);
			
			$return =  $cache[$classname] = current($result);
		}
		return $return;
	}

	public function getClassPath($classname){
		return dirname($this->findClassFile($classname));
	}

	public function getClassFile($classname){
		return $this->findClassFile($classname);
	}
}
