<?php
class Wisdom_Acl{
	static private $_cache = array();
	static private $_cache_controlador = array();

	private static function getRules(){
		$ACL = array();

		if( is_file(CONFIG_PATH."/aclrules.php") ){
			include(CONFIG_PATH."/aclrules.php");
		}else{

		}

		$guest_default_rules = array("login"=>array("display","dologin"));
		
		$default_rules = array('error'=>array('*'));

		if( isset($ACL['guest']) ){
			$ACL['guest'] = $ACL['guest']+$guest_default_rules;
		}else{
			$ACL['guest'] = $guest_default_rules;
		}

		foreach($ACL as &$perfil ){
			$perfil += $default_rules;
		}
		
		unset($perfil);

		return $ACL;
	}

	public static function hasActionPermission($controller,$action){
		$ACL = self::getRules();
		$controller = strtolower($controller);
		$action = strtolower ($action);
		if( isset(self::$_cache[$controller][$action]) ){
			#Ya existe el permiso
		}else{
			if( isset($ACL) ){
				$usr = Wisdom_Utils::accesor()->get('Wisdom_User');
				$rol = is_null($usr->role) ? "guest" : $usr->role;
				self::$_cache[$controller][$action] = FALSE;
				if( isset( $ACL[$rol] ) ){
					if(isset($ACL[$rol][$controller]) ){
						 if(array_search("*",$ACL[$rol][$controller]) !== FALSE 
						 		|| array_search($action, $ACL[$rol][$controller] ) !== FALSE){
						 	self::$_cache[$controller][$action] = TRUE;
						 }
					}elseif(array_key_exists("*",$ACL[$rol])){
						if(array_search("*",$ACL[$rol]["*"]) !== FALSE ||
						array_search($action,$ACL[$rol]["*"]) !== FALSE)
						self::$_cache[$controller][$action] = TRUE;
					}
				}else{
					self::$_cache[$controller][$action] = FALSE;
				}
			}else{
				self::$_cache[$controller][$action] = TRUE;
			}
		}
		return self::$_cache[$controller][$action];
	}

	public static function hasControllerPermission($controller){
		$ACL = self::getRules();
		$controller = strtolower($controller);
		if( isset(self::$_cache_controlador[$controller]) ){
			#Ya existe registro
		} else{
			if( isset($ACL) ){
				$usr = Wisdom_Utils::accesor()->get('Wisdom_User');
				$rol = $usr->role;
				
				if(isset($ACL[$rol])){
					self::$_cache_controlador[$controller] = FALSE;
						
					if ( array_key_exists("*",$ACL[$rol]) || array_key_exists($controller,$ACL[$rol]) ){
						self::$_cache_controlador[$controller] = TRUE;
					}
				}else{
					self::$_cache_controlador[$controller] = FALSE;
				}
			}else{
				self::$_cache_controlador[$controller] = TRUE;
			}
			self::$_cache_controlador[$controller] = CHECKUSER ? self::$_cache_controlador[$controller] : TRUE;
		}

		return  self::$_cache_controlador[$controller];
	}
}
?>
