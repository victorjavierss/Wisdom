<?php
class Helpers_Select{
	public function select($options,$selected = 0,$show_select=0){
		$select =  "<select>";
		if($show_select){
			$select .= "<option value='-1'>--Seleccionar--</option>";	
		}
		foreach($options as $value=>$text){
			
			$option = "<option value='" . (is_string($value)?$value:$text)  . "'";
			
			if($value==$selected){
				$option .= "selected='selected'";
			}
			$option .=">{$text}</option>";
			
			
			$select .= $option;
		}
		$select .="</select>";
		return $select;
	}
}