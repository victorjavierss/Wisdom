<?php
class Wisdom_Preferences{
	private static $_preferences = array();
	private static $_laoaded_adapters;
	public static function get($key){
		return isset(self::$_preferences[$key])?self::$_preferences[$key]:FALSE;
	}

	public static function set($key, $value){
		self::$_preferences[$key] = $value;
	}

	public static function loadAdapter(Wisdom_Preferences_Adapter $adapter){
		$adapter_class = get_class($adapter);
		if( ! isset(self::$_laoaded_adapters[ $adapter_class  ] ) ){
			self::$_preferences = array_merge($adapter->getPreferences(), self::$_preferences);
			self::$_laoaded_adapters[ $adapter_class  ] = true;
		}
	}
}