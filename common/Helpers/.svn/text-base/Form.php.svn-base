<?php
class Helpers_Form{
    public function form(Wisdom_Catalog $catalog,$action = '#' , $method = 'POST'){
        
    	$form   = $catalog->getFormName();
        $fields = $catalog->getFields();
        $hidden = $catalog->getHidden();
        
        $form_html = "<form id='{$form}' method='{$method}' action='{$action}'>
          <table>";

        foreach($fields as $key=>$field){

        	if ( ! in_array($key, $hidden) ){
	            $form_html .= "<tr><td><label for='{$key}'>{$field['label']}";
	            
	            if( isset($field['required']) && $field['required'] ){
	                $form_html .=" *";
	            }
	            
	            $form_html .= "</label></td><td>";
	            if(! isset($field['type'])){
	                $field['type'] = 'text';   
	            }
	            $form_html .= "<input type='{$field['type']}' id='{$key}' name='{$key}' /></td></tr>";
	        }
        }
	        $text = ucwords($form);
			$form_html .="<tr><td colspan='2' align='center'><input id='submit' type='submit' name='submit' value='Guardar' /></td></tr></table></form>";
        
		return $form_html;
    }
}
