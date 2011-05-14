<?php
class Helpers_Img{
    public function img($img, $alt = '', $attribs = array(), $ext = FALSE){
    	
    	static $cache = array();
    	
		$config = $config = Wisdom_Config::get("app");
		
		$style = isset($config['style']) ? "{$config['style']}/" : '';
		
    	$path = URL . "theme/{$style}images/";
    	
		
		if ( ! isset($cache[$img]) && !$ext ){
			$test_ext = array('png','gif','jpg','jpeg');
			foreach($test_ext as $ext_test){
				is_file(APP_HOME.THEME_PATH.DIRECTORY_SEPARATOR."images/{$img}.{$ext_test}")
							&&  $cache[$img] = $ext = $ext_test;
				
			}
		}else{
			$ext = $cache[$img];
		}
		
		
		$attribs_parse = '';
		
		foreach($attribs as $attrib => $value){
			$attrib!='alt' &&
						$attribs_parse .= "{$attrib}='$value'";
		}
        return "<img src='{$path}{$img}.{$ext}' alt='{$alt}' title='{$alt}'  {$attribs_parse} />";
    }
}