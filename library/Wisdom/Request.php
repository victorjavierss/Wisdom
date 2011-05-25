<?php
class Wisdom_Request extends Wisdom_Singleton{

    private $_data     = array();
	private $_is_post  = FALSE;
    const NO_BASE_VARS = TRUE;
    
    public function __get($element){
        return $this->_get($element);
    }
    
    public function getVars($no_base_vars = FALSE){
    	$vars = array_keys($this->_data);
    	if(self::NO_BASE_VARS == $no_base_vars){ 
    		Wisdom_Utils::deleteArrayElements($vars, array('controller','action','lang'));
    	}
    	return $vars;
    }
    
    protected function _get($element){
    	return isset($this->_data[$element]) ? $this->_data[$element] : FALSE;
    }
    
    /**
     * Handles the data from POST and GET for an easy access
     */
    public function init(){
    	if(isset($_POST) && ! empty($_POST)){
          $this->_data = $this->_data + $_POST;
		  $this->_is_post = TRUE;
		}

		$user 		   =  Wisdom_Utils::accesor()->get('Wisdom_User');
          
       	$get                       = isset($_GET["q"]) ? $_GET["q"] : DEFAULT_MODULE; 
       	$get                       = explode("/",$get);
       	
       	if( Wisdom_Acl::hasControllerPermission($get[0])){
       		$this->_data["controller"] = $get[0]; 
       	} else {
       		$this->_data["controller"] = 'login';
       	}

		$this->_data["action"]     = (isset($get[1]) && $get[1] )? $get[1] : "display";
		
		if( ! Wisdom_Acl::hasActionPermission($this->_data["controller"],$this->_data["action"]) ){
			$this->_data["controller"] = 'login';
			$this->_data["action"] 	   = 'display'; 
       	}
       	
       	$items = count($get);
       
       	if( ! isset($this->_data['lang']) ){
       		$config = Wisdom_Config::get('app');
			$this->_data['lang'] = isset($config['lang']) ? $config['lang'] : 'en';
       	}
       	
       
       if($items>2 && $items % 2 != 0){
          // throw new Exception("Not enough parameters for parsing the request");
       }
       
       for($item = 2; $item < $items; $item+=2){
           $this->_data[$get[$item]]= isset($get[$item+1])?$get[$item+1]:FALSE;
       }
    }

	public function isPost(){
		return $this->_is_post;
	}

    public static function isAjax(){
	   return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')?true:false;
	}

	public function getParams(){
		return $this->_data;	
	}
}
