<?php
class Wisdom_Helper extends Wisdom_Singleton{
    
    private $_helpers;
    
    public function __call($helper, $args){
         if( is_null($this->_helpers) || ! array_key_exists($helper,$this->_helpers) ){
                $helper_help = ucwords($helper);
                $this->_helpers[$helper] = Wisdom_Utils::factory()->get('Helpers_' . $helper_help);
         }
         $obj = $this->_helpers[$helper];
         
         return call_user_func_array(array($obj,$helper),$args);
    }

}
