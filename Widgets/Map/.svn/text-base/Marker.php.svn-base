<?php
class Map_Marker extends Wisdom_Controller{
   
   protected $_lang = 0;
   protected $_lat  = 0;
   protected $_infoWindow = null;
    protected $_icon  = null;
   
   public function setLatLang($lat, $lang){
   	 $this->setLat($lat);
   	 $this->setLang($lang);
   }
   
   public function setLang($lang){
   		$this->_lang = $lang;
   }
   
   public function setLat($lat){
   		$this->_lat = $lat;
   }
   
   public function attach(Map_InfoWindow $info_window){
   		$this->_infoWindow = $info_window;
   }
   
   public function getLat(){
   		return $this->_lat;
   }
   
   public function getLang(){
   		return $this->_lang;
   }
   
   public function getLatLang(){
   	return "{$this->getLat()},{$this->getLang()}";
   }
   
   public function getInfo(){
		if ( !is_null ( $this->_infoWindow) ){
			return $this->_infoWindow;
		}else{
			return '';
		}
   }
   
    public function getIcon(){
   		return $this->_icon;
   }
   
    public function setIcon($icon, $image){
   		$this->_icon = $icon;
		$marker_icon = Wisdom_Utils::factory('Map_MarkerImage');
		$marker_icon->addImage($icon, $image);
   }
   
   public function __toString(){
   	$marker_js = "var latlng = new GLatLng({$this->getLatLang()});\nvar content = \"" . ((string)$this->getInfo())  . "\";\nvar marker = new createMarker(latlng, content, {$this->getIcon()});";
   	return $marker_js;
   }
   
   

}
?>