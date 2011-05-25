<?php

//Definir la ubicación de la libreria de WISDOM
define('WISDOM_LIB', WISDOM_HOME . DIRECTORY_SEPARATOR . 'library'. DIRECTORY_SEPARATOR  );

include(WISDOM_LIB . 'Wisdom' . DIRECTORY_SEPARATOR . 'Bootstrap.php');
 
class Wisdom_App {

	static $_self;

	private function __construct(){
		$this->_bootstrap();
	}

	private function _bootstrap(){
		try{
			//Verifies that all directories needed exists
			$this->_checkDirectory();
		}catch(Exception $ex){
			//			self::widget("error","exception",$ex);
			echo "<pre><strong>" . $ex->getMessage() . "</strong><br/>".
			$ex->getTraceAsString().
                 "</pre>";
			exit;
		}
	}

	/**
	 * Valida las rutas necesarias para el funcionamiento del sistema
	 */
	private function _checkDirectory(){
		if(!is_dir(WISDOM_HOME)){
			throw new Exception("The Framework path is misconfigured");
		}

		if(!is_dir(APP_HOME)){
			throw new Exception("Application path is misconfigured");
		}

		if(!is_dir(CONFIG_PATH)){
			throw new Exception("Config path is misconfigured");
		}

		if(!is_dir(MODULES_PATH)){
			throw new Exception("Modules path is misconfigured");
		}

		
		if(!is_dir(APP_HOME.THEME_PATH)){
			throw new Exception("The Theme path (" . APP_HOME.THEME_PATH .") is misconfigured");
		}

		if(!is_dir(APP_HOME.JAVASCRIPT_PATH)){
			throw new Exception("Javascript is misconfigured");
		}

		if(!class_exists(DEFAULT_MODULE.'_Controller')){
			$home_page = MODULES_PATH . "/" . DEFAULT_MODULE;
			throw new Exception("{$home_page}: Controller for home page is not found");
		}
	}

	public static function parse(){
		$app = self::$_self = self::getInstance();

		$req = Wisdom_Utils::factory('Wisdom_Request');
		
		$raw = $app->loadController($req->controller, $req->action);
		
		!$raw && Wisdom_View::render();

		$config = Wisdom_Utils::factory('Wisdom_Config');
		$_SESSION['config'] = serialize($config);
	}
	 
	public static function widget($widget,$action="display",$params=array()){
		$user = Wisdom_Utils::accesor()->get('Wisdom_User');
		$load = CHECKUSER ? $user->auth  : true;
		if($load){
			self::$_self->loadController($widget,$action,$params);
		}elseif ($widget=="login" || $widget=="error"){
			self::$_self->loadController($widget,$action,$params);
		}
	}

	
	public static function getInstance(){
		if( ! isset(self::$_self)){
			self::$_self = new Wisdom_App();
		}
		return self::$_self;
	}
	

	public static function load($item){
		$user = new Wisdom_User();
		$load = CHECKUSER ? $user->auth : true;
		if($load){
			View::element($item,APP_HOME."/common");
		}else{
			//Not load the item
		}
	}
	 
	public function loadController($controller, $action="", $params=null){
		try{
			$parametros_magic [] = $controller;
			$mController = Wisdom_Utils::accesor()->get('Wisdom_Magic',$parametros_magic);
			if(! is_null($mController)){
				return $mController->lala($action, $params);
			}
		}catch (Exception $ex){
			switch($ex->getCode()){
				case 1 : $error = "controller";
				break;
				case 2 : $error = "denied";
				break;
				case 3:  $error = "view";
				break;
				default: $error = "exception";
				break;
			}
			if($controller=="error"){
				echo "<pre>{$ex}</pre>";
			} else {
				Wisdom_App::widget("error",$error,$ex);
			}
		}
	}

	public static function redirect($location, $baseURL=URL){
		$helper_handler = Wisdom_Utils::factory()->get('Wisdom_Helper');
		$location = $helper_handler->url($location);
		header("Location: {$location}");
	}
}

?>
