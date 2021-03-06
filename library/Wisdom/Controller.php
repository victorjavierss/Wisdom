<?php
abstract Class Wisdom_Controller{

	protected $_Model     = NULL;
	protected $_Module    = NULL;
	protected $_Path      = NULL;
	protected $_request   = NULL;
	protected $_view_args = array();
	private   $_Type      = "Module";
	protected $_render    = TRUE;
	 
	protected $_raw_output = FALSE;

	public function __construct(){
		$module = get_called_class();
		$module = explode("_",$module);
		$this->_request = Wisdom_Utils::factory()->get('Wisdom_Request');
		$this->_Module = $module[0];
	}

	public function isRaw(){
		return $this->_raw_output;
	}
/**
 * 
 * Enter description here ...
 * @return Wisdom_Request
 */
	protected function getRequest(){
		return $this->_request;
	}
	 
	protected function noRender(){
		$this->_render = FALSE;
	}

	public function dispatch($action,$args){
		if(is_callable(array($this, $action))){
			call_user_func_array(array($this,$action),$args);
			if( $this->_render ){
				$this->_view_args["model"]=$this->getModel();
				Wisdom_View::page($this->_view_args,$action);
			}else{
				#No rendered view needed
			}
			return $this->_raw_output;
		}else{
			$controller_class = get_called_class();
			throw new Exception("Action {$action} is not callable for controller {$controller_class}",1);
		}
	}
	 
	protected function setViewVar($var_name, $value){
		$this->_view_args[$var_name] = $value;
	}
	 
	public function initModel($model = NULL){
		if($model instanceOf Wisdom_Model){
			$this->_Model = $model;
		}else{
			if ( is_file($this->_Path."/Model.php") ){
				$this->_Model = Wisdom_Utils::accesor()->get($this->_Module.'_Model');
			}
		}
	}
	 
	/**
	 *
	 * @return Wisdom_Model
	 */
	public function getModel(){
		return $this->_Model;
	}
	 
	protected function setModel(Model $model){
		$this->_Model = $model;
	}
	 
	public function setType($type){
		$this->_Type=$type;
	}
	 
	public function getType(){
		return $this->_Type;
	}
	 
	public function setPath($path){
		$this->_Path=$path;
	}
	 
	public function getPath(){
		return $this->_Path;
	}
	 
	public function getModule(){
		return $this->_Module;
	}
	 
	public function display(){}

}
?>
