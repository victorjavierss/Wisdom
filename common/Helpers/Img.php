<?php
class Helpers_Img extends Wisdom_Helper{
    public function img($img, $alt = '', $attribs = array(), $ext = FALSE){
    	static $cache = array();
		$config = $config = Wisdom_Config::get("app");
		$style = Wisdom_Preferences::get('style');
		$style && $style = "{$style}/";
    	$path = URL . "theme/{$style}images/";
    	$theme_dir = APP_HOME.THEME_PATH.DIRECTORY_SEPARATOR.$style;
		
		if ( ! isset($cache[$img]) && !$ext ){
			$test_ext = array('png','gif','jpg','jpeg');
			foreach($test_ext as $ext_test){
				is_file($theme_dir."images/{$img}.{$ext_test}")
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