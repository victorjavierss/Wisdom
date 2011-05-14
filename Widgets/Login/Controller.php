<?php
class Login_Controller extends Wisdom_Controller{
    
	public function display(){
	
		$fields = $this->getModel()->getFields();

		$auth_config  = Wisdom_Config::get("auth");		
		$password_field = $auth_config["credentials.password"];
		
		$user_field = $auth_config["credentials.user"];
		
		Wisdom_Utils::deleteArrayElementsByKey($fields,array($user_field, $password_field));
		
		$this->_hidden_fields = array_keys($fields);
		
		$auth_config  = Wisdom_Config::get("auth");
		
		$this->setViewVar('pass_field', $password_field);
	}
	
    public function dologin( $user = NULL, $password = NULL){
    	
    	$auth_config  = Wisdom_Config::get("auth");
        
        $username_field = $auth_config["credentials.user"];
        $password_field = $auth_config["credentials.password"];
    	
		$request = $this->getRequest();
		$usr = $user ? $user : $request->$username_field  ; 
		$psw = $password ? $password : $request->$password_field;
        
		$select =  $this->_Model->getSelect();
		
		$select->where("{$username_field}= ?",$usr)->where("{$password_field}= ?",$psw);	

		$data = $this->_Model->fetchRow($select, PDO::FETCH_ASSOC);
		
	 	if($data === FALSE){
	 	    $loged = FALSE;
	 	}else{
		    $loged               = TRUE;
	 		$_SESSION["profile"] = $data;  
	 	}
		
        $this->setViewVar("success", $loged);
    }
    
     public function logout(){
	     session_destroy();
         Wisdom_App::redirect("");
    }
	 
    public function info(){
    	$this->setViewVar("user",Wisdom_Utils::accesor()->get('Wisdom_User'));
    }

}
?>