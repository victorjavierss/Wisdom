<?php
class Map_Controller extends Wisdom_Controller{
   	    
       public function display($markers = array(),
								$coordenadas = array('lat'=>23.1977598301824,
													 'lng'=>-100.424995064735),
								$zoom_level = 5){
       	     
       	     if( is_array($markers) ){
               foreach($markers as $key => $marker){
                   if( ! $marker instanceof Map_Marker ){
                   		unset($markers[$key]);
                   }
               }
       	     } elseif ($markers instanceof Map_Marker) {
       	     	$markers = array($markers);
       	     }else{
       	     	$markers = array();
       	     }
               
             $this->setviewVar('markers', $markers);
             $this->setviewVar('zoom', $zoom_level);
			 $this->setviewVar('lat',  $coordenadas['lat']);
			 $this->setviewVar('lng',  $coordenadas['lng']);
			 //$this->setviewVar('icono',  $icono);
       }
       
}
?>