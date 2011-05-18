<?php

class Helpers_Link  {
	public function link($html, $href = '#', $attributes = array()){
		if (substr($href, 0, strlen('javascript:')) == 'javascript:') {
			$attributes["onclick"] = substr ($href, strlen ('javascript:'));
			$href    = 'javascript:void(0);';
		} else {
			//
		}

		if(is_null($href)){
			//no queremos href
		} else {
			$attributes['href'] = $href;
		}

		$attributes_str = '';
		foreach($attributes as $name=>$value){
			$attributes_str  = "{$name}='$value'";
		}

		$html_link = "<a ". $attributes_str . ">" . $html . "</a>";

		return $html_link;

	}

}


?>
