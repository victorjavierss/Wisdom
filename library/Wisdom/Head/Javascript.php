<?php
class Wisdom_Head_Javascript extends Wisdom_Singleton{
	protected $_js_include = array();
	protected $_js_capture = array();
	
	public function jsInclude($js_script_file){
		if(!in_array($js_script_file, $this->_js_include)){
			$this->_js_include [] = $js_script_file;
		}
	}
	
	public function startCapture(){
		ob_start();
	}

	public function endCapture(){
		$this->_js_capture[] = str_replace(array('\n','\t'), null, ob_get_clean()) ;
	}

	public function render(){
		$javascript = "";
		foreach($this->_js_include as $script){
			$javascript .= "<script type='text/javascript' src='{$script}'></script>";
		}
		if($this->_js_capture){
			$javascript .= "<script type='text/javascript'>\n
					//<![CDATA[\n";
			$javascript .= implode("\n", $this->_js_capture);
			$javascript .= "//]]>\n
				</script>";
		}
		return $javascript;
	}
	
	public function __toString(){
		return $this->render();
	}
}