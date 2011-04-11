<?php
class Wisdom_Services extends Wisdom_Singleton{

	private function factory($service, $args){
		$paths[] = APP_HOME  . DIRECTORY_SEPARATOR . 'services'  . DIRECTORY_SEPARATOR;
		$paths[] = WISDOM_LIB  . 'Services'  . DIRECTORY_SEPARATOR;
	   	$classname = str_replace('_', '/',$service);
	        $include    = FALSE;
        	foreach($paths as $path){
        		if( is_file($path.$classname.".php") ){
        	    	$include = $path.$classname.".php";
        	    }
		}
		if( ! $include ){
        	throw new Exception("Service {$service} doesn't exists");
        }

   		include_once $include;
   		
		 if( is_string($args) ){
			$args = array($args);
      		  }elseif( ! is_array($args)){
			$args = array();
       		 }
	$classname = "Services_$classname";

		if( count($args)>0 ){
	    	$reflection_class = new ReflectionClass($classname);			
			if (is_object ($reflection_class->getConstructor ())) {
				$instance = $reflection_class->newInstanceArgs ($args);
			}else{
				throw new Exception("La clase '{$classname}' no puede ser instanciada, {$include}");
			} 
         }else {
			 $instance = new $classname ();
		} 
	   	return $instance;
	}

	public function __call($service,$args){
		return $this->factory($service,$args);
    }	

	public static function __callstatic($service, $args){
		$factory = new Wisdom_Services();
	  	return call_user_func_array(array($factory,$service),$args);
	}
	
}
