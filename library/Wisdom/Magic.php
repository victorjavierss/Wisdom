<?php
class Wisdom_Magic{

	private $_Controller;

	public function __construct($controller){
		$controller = ucwords($controller);
		 
		$class = "{$controller}_Controller";
		$hasPermission = Wisdom_Acl::hasControllerPermission($controller);
		
		if($hasPermission){
			try {
				$this->_Controller = Wisdom_Utils::accesor()->get($class);
			}catch(Exception $ex){
				throw new Exception("Module {$controller} doesn't exits",1);
			}
			$path = Wisdom_Utils::accesor()->getClassPath($class);
			$this->_Controller->setPath($path);

			$w_regex = 'widgets\\'.DIRECTORY_SEPARATOR.'[a-zA-Z]';
			$m_regex = 'module\\'.DIRECTORY_SEPARATOR.'[a-zA-Z]';

			if( preg_match("/{$w_regex}/i",$path) ){
				$this->_Controller->setType('widget');
			}elseif( preg_match("/{$m_regex}/",$path) ){
				$this->_Controller->setType('module');
			}else{
				$this->_Controller->setType('unknown');
			}

			$this->_Controller->initModel();
		}else{
			throw new Exception("Denied",2);
		}
	}

	public function lala($action, $params=array()){
		if ( ! is_null($this->_Controller) ){
			$controller_class = get_class($this->_Controller);

			if(! is_null($this->_Controller) && is_callable(array($this->_Controller, $action))){
				$can_do =  Wisdom_Acl::hasActionPermission($this->_Controller->getModule(),$action);
				if($can_do){
					if(is_null($params)){
						$params=array();
					}elseif( ! is_array($params)) {
						if($params instanceOF Exception){
							$ex = $params;
							unset($params);
							$params = array ($ex);
						}else{
							$params [] = $params;
						}
					}
					$this->_Controller->dispatch($action,$params);
				} else {
					throw new Exception("Action Denied",2);
				}
			} else {
				throw new Exception("Action {$action} is not callable for controller {$controller_class}",1);
			}
		} else {
			throw new Exception("Action Denied",2);
		}
	}
}
