<?php
class Helpers_SysLink  extends Wisdom_Helper{
	public function sysLink($html, $seccion, $attributes = array()){
		$config = Wisdom_Utils::factory('Wisdom_Config');
		$app = $config->app;
		$fancy_links = (bool)$app['fancy_links'];
		$fancy= $fancy_links?NULL:'?q='; 
		$href = $this->url() . $fancy . $seccion;
		return $this->link($html, $href, $attributes);
	}
}
