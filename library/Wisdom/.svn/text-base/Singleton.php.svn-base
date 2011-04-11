<?php

abstract class Wisdom_Singleton{
	
	protected function __construct() {}
   
	/**
	 * Initial procedure for instantiating the object
	 * @return No return
	 */
    protected function init(){}
	
	
    public static function getInstance( $calledClassName = NULL ){
        static $aoInstance = array(); 

        if ( ! $calledClassName ){
	    $calledClassName = get_called_class(); 
        }
        
        if (! isset ($aoInstance[$calledClassName])) { 
            $aoInstance[$calledClassName] = new $calledClassName(); 
			$aoInstance[$calledClassName]->init();
        } 

        return $aoInstance[$calledClassName]; 
  }
  
  public static function i($calledClassName){ 
      return self::getInstance($calledClassName);
  }
  
   //No se puede clonar
   final private function __clone(){return null;}
}
