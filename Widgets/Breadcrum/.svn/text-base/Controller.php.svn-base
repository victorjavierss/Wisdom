<?php

class Breadcrum_Controller  extends Wisdom_Widget_Abstract{

	public function init(){
		$req = $this->getRequest();
		$options = $req->getVars(Wisdom_Request::NO_BASE_VARS);

		$controller = $req->controller;
		$action = $req->action;
		
		$this->url = URL . "breadcrum/display/home/$controller/otro/$action";
	}
	
	public function display(){
		$req = $this->getRequest();
		$options = $req->getVars(Wisdom_Request::NO_BASE_VARS);
		foreach($options as $option)
			echo $req->$option. " >> ";
	}
}

?>
