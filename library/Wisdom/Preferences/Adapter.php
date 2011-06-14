<?php
class Wisdom_Preferences_Adapter{
	public function getPreferences(){
		$config = Wisdom_Utils::factory('Wisdom_Config');
		return $config->app;
	}
}