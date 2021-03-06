<?php
class Wisdom_User{
    public function __get($att){
    	$config = Wisdom_Utils::accesor()->get('Wisdom_Config');

		if ( ! isset($_SESSION["profile"])){
			$translator = Wisdom_Utils::factory()->get('Wisdom_Services')->Translator();
			$_SESSION["profile"]['role']     = 'guest';
			$_SESSION["profile"]['fullname'] = $translator->guest;
		}
		
		if( is_object($_SESSION["profile"]) ){
			$_SESSION["profile"] = Wisdom_Utils::objectToArray($_SESSION["profile"]);
		}
		
		$ret = isset($_SESSION["profile"][$att]) ? $_SESSION["profile"][$att] : null;
        
        if($att=='auth'){
        	$id  = $config->auth["primary"];
        	$ret = isset($_SESSION["profile"][$id]) ? TRUE : FALSE;
            $ret = CHECKUSER ? $ret : TRUE;
        }elseif($att=="role"){
        	if ( $this->__get('auth') ){
	        	$role_field = $config->auth["credentials.role"];
	        	$ret = isset($_SESSION["profile"][$role_field]) ? $_SESSION["profile"][$role_field] : 'user';
        	}else {
        		$ret = 'guest';
        	}
        }elseif($att=="fullname"){
		    if( ! isset($_SESSION['profile']['fullname']) ){
				$fullname_fields = explode(',',$config->auth['fullname']);
				foreach ($fullname_fields as $fullname_field) {
					isset($_SESSION['profile'][$fullname_field]) && $ret .=  $_SESSION['profile'][$fullname_field] . ' '; 
				}
			}else{
			   $ret = $_SESSION['profile']['fullname'];
			}
        }
        
        return $ret;
    }
}

?>
