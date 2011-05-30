<?php
class Wisdom_Json_Controller extends Wisdom_Controller{
	public function __construct(){
		parent::__construct();
		if ( ! Wisdom_Request::isAjax() ){
			throw new Exception('Error accesing this content');
		}
		set_error_handler(array($this, 'error'));
	}

	public function error($errno ,  $errstr, $errfile , $errline , $errcontext ){
		ob_clean();
		if (error_reporting() == 0) {
			return;
		}
		$error = array(
   					'success' => 'false'
   					,'message' => $errstr
   					);
   					echo json_encode($error);
   					die;
	}

public function dispatch($action,$args){
		try{
			if($action == 'error'){
				throw new Exception('Invalid action', $code);
			}else{
				if( is_callable(array($this, $action)) ){
					parent::dispatch($action, $args);
				}else{
					$error [ 'success' ] = FALSE;
					$error [ 'errors'  ] = "The content you are trying to access doesn't exists or you don't have permission";
					echo json_encode($error);
				}
			}
		}catch (Exception $ex){
			$error = array(
   					'success' => 'false'
   					,'message' => $ex->getMessage()
   					);
   					echo json_encode($error);
		}
	}
}