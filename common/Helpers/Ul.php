<?php
class Helpers_Ul extends Wisdom_Helper{
	public function ul($items){
		return  "<ul><li>" . implode("</li><li>", $items) .  "</li></ul>";
	}
}