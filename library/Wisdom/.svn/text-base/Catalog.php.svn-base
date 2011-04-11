<?php
class Wisdom_Catalog extends Wisdom_Model {
	
	private $_catalog_options_default = array(
	                                 'header'=>array('add','separator','search'),
	                                 'body'  =>array('id'=>array('actions'=>'delete,edit')),
	                                 'footer'=>array('items'=>array(10,20,30,40,50,100),'separator','first','prev','paginate','next','last','separator','totalitems')
	                               );

	protected $_buttons         = array(
									'submit' => array('type'=>'submit','value'=>'Guardar')
								  );
	                               
	protected $_catalog_options = NULL;
	
	protected $_order         = array();
	protected $_helpers       = array();
	protected $_hidden_fields = array();
	protected $_labels        = array();
	
	protected function _getFields(){
		$all_fields = $this->getTable()->getFields();
		$all_fields_keys = array_keys($all_fields);
		$visible_fields_keys = array_diff($all_fields_keys,$this->_hidden_fields);
		$visible_fields = array();
		if( empty($this->_order)){
			$this->_order = $visible_fields_keys;	
		}else{
			#Se se un orden por default
		}
		foreach($this->_order as $ordered_field){
			if ( in_array($ordered_field,$visible_fields_keys) ){
//				foreach ($visible_fields_keys as $field){
					$visible_fields[$ordered_field] = $all_fields[$ordered_field];
					$visible_fields[$ordered_field]['label'] = isset($this->_labels[$ordered_field]) ? 
																		$this->_labels[$ordered_field] : $all_fields[$ordered_field]['label'];
					if( isset($this->_helpers[$ordered_field]) ){
						$visible_fields[$ordered_field]['helper'] = $this->_helpers[$ordered_field];
					}else{
						#No se agrega helper
					}
//				}
			}else{
				#No se especifico un orden
			}
		}
		return $visible_fields;
	}

	public function getFields(){
		static $fields = FALSE; 
		if (  !$fields ){
			 $fields = $this->_getFields();
		}else{
			#Ya estan definidos los campo
		}
		return $fields;
	}

	public function getHidden(){
		return $this->_hidden_fields;
	}
	
}


?>
