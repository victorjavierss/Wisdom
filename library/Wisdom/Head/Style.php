<?php
class Wisdom_Head_Style extends Wisdom_Singleton{

	protected $_wisdom_style = array();
	protected $_app_style = array();
	protected $_other_style = array();
	protected $_app_ie_style = array();
	protected $_other_ie_style = array();
	protected $_embbebed_style = array();

	protected function addIeStyles($path, $prefix){
		$ie_dirs = Wisdom_Utils::getDirs($path, array('images'));
		$result = array(); 
		foreach ( $ie_dirs as $ie_dir ){
			if( preg_match("/ie/", $ie_dir) ){
				$name = "IE";
				if(preg_match("/gte/",$ie_dir)){
					$name .= ' GTE ';
				}elseif(preg_match("/gt/", $ie_dir)){
					$name .= ' GT ';
				}elseif(preg_match("/lte/",$ie_dir)){
					$name .= ' LTE ';
				}elseif(preg_match("/lt/",$ie_dir)){
					$name .= ' LT ';
				}else{
					#No tiene GT o LTE
				}
				$ie_dir = explode("/",$ie_dir);
				$ie_dir = array_pop($ie_dir);
				$number = preg_replace("/[^0-9\.]/", NULL,$ie_dir);
				$name .= " $number";
				$result[$name] = $this->addStyles($path."/".$ie_dir, $prefix."/".$ie_dir); 
			}else{
				#No es un folder con contenido para IE
			}
		}
		return $result;
	}

	protected function addStyles($path, $prefix){
		$styles = array();
		$files = Wisdom_Utils::getFilesFromDir($path, FALSE);
		foreach($files as $file){
			$styles[] = "{$prefix}/{$file}";
		}
		return $styles;
	}

	public function addWidgetStyle($widget){
		//FIXME no siempre son widgets =S
		$path = WISDOM_WIDGETS . "/{$widget}/theme";
		$this->_other_style    = $this->addStyles($path, "../wisdom/Widgets/{$widget}/theme");
		$this->_other_ie_style = $this->addIeStyles($path, "../wisdom/Widgets/{$widget}/theme");
	}

	public function addCoreStyle(){
		$this->_wisdom_style = $this->addStyles(WISDOM_HOME."/theme", "../wisdom/theme");
	}

	public function addAppStyle(){
		
		$style = Wisdom_Preferences::get('style');

		$path = APP_HOME.THEME_PATH.'/'.$style;
		
		$req = Wisdom_Utils::factory("Wisdom_Request");
		$controller = $req->controller;
		$action     = $req->action;
		
		$prefix = THEME_PATH.'/'.$style;
		
		if( is_dir($path."/{$controller}-{$action}") ){
			$path = $path . "/{$controller}-{$action}";
			$prefix = THEME_PATH . "/{$controller}-{$action}";
		}elseif(is_dir($path . "/{$controller}")){
			$path = $path . "/{$controller}";
			$prefix = THEME_PATH . "/{$controller}";
		}else{
			#Se carga configuración por defecto
		}
		
		$this->_app_style    = $this->addStyles($path, $prefix);
		$this->_app_ie_style = $this->addIeStyles($path, $prefix);
	}

	public function addStyle($style){
		$this->_embbebed_style [] = $style;
	}

	protected function renderCssLink($style){
		return "<link href='".URL."{$style}' rel='stylesheet' type='text/css' />";
	}
	
	public function render(){
		$css=array();

		$styles = array_merge($this->_wisdom_style, $this->_other_style, $this->_app_style);
		
		foreach($styles as $style){
			$css[] = $this->renderCssLink($style);
		}

		$ie_styles = array_merge($this->_other_ie_style, $this->_app_ie_style);
		
		foreach ($ie_styles as $hack => $ie_style){
			$ie_hacks = array();
			foreach ($ie_style as $style) {
				$ie_hacks[] = $this->renderCssLink($style);
			}
			$ie_hack = implode("", $ie_hacks); 
			$ie_hack = "<!--[if {$hack}]>{$ie_hack}<![endif]-->";
			$css[] = $ie_hack;
		}
		
		
		if(count($this->_embbebed_style)){
			$embbebed = implode("", $this->_embbebed_style);
			$css [] = "<style type='text/css'>{$embbebed}</style>";
		}else{
			#No hay estilos embebidos
		}

		return implode("", $css);
	}

	public function __toString(){
		return $this->render();
	}
}