<?php

class Services_Translator  {

	private $_default_lang;
	private $_lang;

	public function __construct(){
		$req = Wisdom_Utils::factory("Wisdom_Request");
		$this->_lang = $req->lang;
		$config = Wisdom_Config::get("app");
		$this->_default_lang = isset($config['lang']) ? $config['lang'] : 'es'; 
	}

	public function translate($message_code){
		
		static $_cache;
		
		if ( ! isset($_cache[$message_code]) ){
			$lang_file = CONFIG_PATH . "/lang/{$this->_lang}.xml" ;
			$lang_path = dirname($lang_file);
			if( is_dir($lang_path) ){
				$service = Wisdom_Utils::factory('Wisdom_Services');
				$xml_lang = $service->xml($lang_file);
				$message = $xml_lang->$message_code;
				$message = (string)$message;
				$message = $message ? $message : ucfirst($message_code);
				$_cache[$message_code] = $message ;
			}else{
				$message = ucfirst($message_code);
			}
		}else{
			$message = $_cache[$message_code];
		}

		return $message;
	}

	public function __get($message_code){
		return $this->translate($message_code);
	}

}

?>
