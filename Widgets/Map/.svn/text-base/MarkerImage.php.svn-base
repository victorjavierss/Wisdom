<?php
class Map_MarkerImage extends Wisdom_Singleton{

	const WIDTH_DEFAULT  = 25;
	const HEIGHT_DEFAULT = 24;
	
	const WIDTH  = 'width';
	const HEIGHT = 'height';
	
	protected $_icons = array();
	
	protected $_sizes = array();
	
	protected $_shadows = array();
	
	public function addImage($key, $image){
		$this->_icons[$key] = $image;
	}
	
	public function removeImage($key){
		unset($this->_icons[$key]);
	}
	
	public function setSize($key, $w, $h){
		$this->_sizes[$key][self::WIDTH] = $w;
		$this->_sizes[$key][self::HEIGHT] = $h;
	}
	
	public function getSize($key){
		if(isset( $this->_sizes[$key] )){
			return $this->_sizes[$key][self::WIDTH] .",".$this->_sizes[$key][self::HEIGHT];
		}else{
			return self::WIDTH_DEFAULT.",".self::HEIGHT_DEFAULT;
		}
	}

	public function getShadow($key){
		if(isset( $this->_sizes[$key] )){
			return "//agregar shadow";
		}else{
			return "";
		}
	}
					

	public function __toString(){
		if(count($this->_icons) > 0 ){
			$iconos = "var icons = " . json_encode($this->_icons) . ";";
			foreach($this->_icons as $key => $icon){
				$iconos .= "\nvar {$key} = new GIcon(G_DEFAULT_ICON);\n 
				{$key}.shadow = null;\n 
				{$key}.image = icons.{$key};\n
				{$key}.iconSize = new GSize(" . $this->getSize($key) . "); \n";
			}
			return $iconos;
		}else{
			return "//No icons";
		}
	}
}
?>