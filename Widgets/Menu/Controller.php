<?php
class Menu_Controller extends Wisdom_Controller {

	public function display($current = NULL){
		$menu  = Wisdom_Config::get("menu");
		if( isset($menu['options']) ){
			$options = $menu['options'];
			$options = explode(',',$options);
			$items = array();
			$req = $this->getRequest();
			foreach($options as $option){
				$opt = new stdClass();
				
				$services = Wisdom_Utils::factory("Wisdom_Services");
				
				//label
				$opt->label = isset($menu["{$option}.label"]) 
									? $menu["{$option}.label"] 
									: ucfirst($services->translator()->translate($option));

				//link
				if(isset($menu["{$option}.link"])){
					$opt->link = str_replace('_BASEURL_',URL,$menu["{$option}.link"]);
				}elseif(isset($menu["{$option}.module"])){
					$module = $menu["{$option}.module"];
					$helper = Wisdom_Utils::factory('Wisdom_Helper');
					$opt->link = $helper->url($module); 
					
				}else{
					$opt->link = "#";
				}
				//icon				
				$current = (isset($module) && strcasecmp("{$req->controller}/{$req->action}",$module)==0) ? "class='current'"
								: NULL;
				$opt->current = $current;
				$items[] = $opt;
			}
			$this->setViewVar('items', $items);
		}else{
			throw new Exception('No options for menu where setted');
		}
	}
}
?>
