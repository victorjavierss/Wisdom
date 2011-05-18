<?php
class Helpers_Url{
    public function url($extra = NULL){
    	$config = Wisdom_Utils::factory('Wisdom_Config');
		$app = $config->app;
		$fancy_links = (bool)$app['fancy_links'];
		$fancy= $fancy_links?NULL:'?q='; 
    	$extra && $extra = $fancy.$extra; 
        return URL.$extra;
    }
}