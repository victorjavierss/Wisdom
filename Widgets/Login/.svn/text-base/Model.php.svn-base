<?php
class Login_Model extends Wisdom_Catalog {

	protected $_form_name      = 'login';
	private   $_password_field = NULL;
	private   $_username_field = NULL;
	
	
	public function __construct(){
		$auth_config  = Wisdom_Config::get("auth");
		$this->_table = $auth_config["table"];
		parent::__construct();
	}

	public function init(){
		
		$auth_config  = Wisdom_Config::get("auth");
		$_password_field = $auth_config["credentials.password"];
		$_username_field = $auth_config["credentials.user"];
		
		$this->_labels[$_password_field] = "Password";
		$this->_labels[$_username_field] = "Nombre de Usuario";

		
		$fields = $this->getFields();

		foreach ($fields as $field_name => $desc) {
			if ( $field_name != $_password_field && $field_name != $_username_field ){
				$this->_hidden_fields [] = $field_name;
			}
		}

	}

	public function getFormName(){
		return 'login';
	}
}
?>
