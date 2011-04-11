<?php

abstract class Wisdom_Widget_Abstract extends Wisdom_Controller implements Wisdom_Widget_Interface{

	protected $url;
	
	public function __toString(){
		try{
			$content_pane = Wisdom_Utils::factory("Helpers_ContentPane");
			$return = $content_pane->contentPane($this->url);
		}catch(Exception $ex){
			$return = $ex->getMessage();
		}
		return  $return;
	}

	public function init(){}
	
}


?>
