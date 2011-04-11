<?php
class Map_InfoWindow extends Wisdom_Controller{
   
   
   protected $_template = "<span style='font-size: 8pt; font-family: verdana'><strong>_TITLE_</strong> <br />_CONTENT_<br />_LINK_</span>";
   //protected $_template = "<span style='font-size: 8pt; font-family: verdana'><strong>Adrian Lira Beltran</strong> <br />Asesor de politica digital<br /> Sistema Nacional e-Mexico<br />ver detalle , sitio web, agenda digital</span>";
   protected $_title   = "";
   protected $_content = "";
   protected $_link    = "";
   
	
   public function setContent($content){
   		$this->_content = $content;
   }
   
   public function getContent(){
   		return $this->_content;
   }
   
   public function __toString(){
    $template = $this->_template;
	
	$replace =  array('_TITLE_','_CONTENT_','_LINK_');
	$replacement = array($this->getTitle(),$this->getContent(),$this->getLink());
	
	$template = str_replace($replace, $replacement, $template);
	
   	return $template;
   }
   
   public function setLink($link, $text, $target = '_self'){
		$this->_link = "<a target='{$target}' href='{$link}'>{$text}</a>";
   }
   
   public function getLink(){
	return $this->_link;
   }
   
   public function clearLink(){
		$this->link = "";
   }
   
   public function setTitle($title){
	$this->_title = $title;
   }
   
   public function getTitle(){
	return $this->_title;
   }
   
}
?>