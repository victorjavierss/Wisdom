<?php

/** 
 * @author vsanchez
 */
class Wisdom_Widget {
	
	private $_widgets = array();
	
	function __construct() {}
	
	public function __call($widget, $args){
	  $widget = ucfirst($widget);
	  $widget_obj =  Wisdom_Utils::factory($widget.'_Controller');
      if( $widget_obj instanceOf Wisdom_Widget_Interface AND $widget_obj instanceOf Wisdom_Controller ){
      	
      	 $widget_obj->init($args);
      	 Wisdom_View::header($widget);
      	 return $widget_obj;

      }else{
      	throw new Exception($widget . ' no es una instancia de Widget_Interface');
      }
    }
}

?>
