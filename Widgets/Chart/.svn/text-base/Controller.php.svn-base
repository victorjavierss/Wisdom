<?php
class Chart_Controller extends Wisdom_Widget_Abstract{
    
	public function display(){
		$this->_render = FALSE;
	}
    
   	public function pie($data){
		$total = 0;
		foreach($data as $value){
		    $total += $value;
        }
        
        $keys="";
        $values="";
        foreach($data as $key => $value){
            $keys .= $key."|";
            $values .=  ($value / $total * 100 ) .",";
        }
        $keys=substr($keys,0,-1);
        $values=substr($values,0,-1);
        
        echo "<img src='http://chart.apis.google.com/chart?cht=p3&chs=270x100&chd=t:{$values}&chl={$keys}' />";
        
        $this->_render = FALSE;
        
    }
    
    function main(){
    	
    }
    
    
} 

?>
