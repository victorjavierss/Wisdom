<?php
class Error_Controller extends Wisdom_Controller{
    
	public function denied(){}
    
    public function view(){}
    
    public function controller($msg = null){
    	
    	$message = $msg ?  $msg->getMessage() : "Error in controller";
    	
    	$this->setViewVar('message',$message);
    	
    }
    
    public function exception($ex = NULL){
    	$message = $ex ? $ex->getMessage() : "Exception";
    	$debug = $ex ? $ex->getTraceAsString() : "";
    	
        $message="<strong>{$message}</strong>";
        
        if(DEBUG){
        	$message .= "<pre>{$debug}</pre>";
        }
        
        $this->setViewVar('message',$message);
    }
}
