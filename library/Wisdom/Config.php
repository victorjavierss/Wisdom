<?php
class Wisdom_Config{
	
	private $_config = array();

	private function __construct($ini = 'config'){
		
		if( ! isset($this->_config[$ini]) ){
			if ( is_file(CONFIG_PATH . "/{$ini}.ini")){
				$ini_file = CONFIG_PATH . "/{$ini}.ini";
				$this->_config[$ini]  = parse_ini_file($ini_file,TRUE);
		    	} else { 
				throw new Exception( ucwords($ini) . ' config file not found');
		    	}
		}
	}

	public static function getInstance($class, $ini = 'config'){
		static $instances;
		if (is_array($ini)){ 
			$ini = current($ini) ? current($ini) : 'config';
		}else{
		}

		if (  ! isset( $instances [$ini] ) ){
			$instances [$ini] = new Wisdom_Config($ini);
		}

		return $instances [$ini];
	}

	
	public function __get($section){
		return $this->_get($section);
	}
	
	private function _get($section,$ini = 'config'){
	    return isset($this->_config[$ini][$section]) ? $this->_config[$ini][$section] : FALSE;
	}
	
	public static function get($section,$ini = 'config'){
		$config = Wisdom_Config::getInstance(NULL, $ini);
		return $config->_get($section, $ini);
	} 

	

}
