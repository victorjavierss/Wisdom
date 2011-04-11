<?php
class Wisdom_Db_MS_Table extends Wisdom_Db_Table{

	public function describe(){
		$sql = "sp_columns {$this->_name}";
		$this->_db->query($sql);

		$fields = array();
		
		while($field = $this->_db->fetch()){
			
			$field_description['label'] = str_replace('id_','',$field->COLUMN_NAME);

			$is_enum_set = FALSE;

			if($field->COLUMN_NAME == 'email' ){
				$field_description['validate'] = 'email';
			} else{
				foreach($this->_data_type_validations as $type=> $validation){
					if(preg_match("/{$type}/",$field->TYPE_NAME)){
						if( $type=='enum' || $type=='set' ){
							$is_enum_set = TRUE;
						}
						$field_description['validate'] = $validation;
						break;
					}
				}
			}

			if($field->COLUMN_NAME == 'password' || $field->COLUMN_NAME == 'psw' ){
				$field_description['type']   = 'password';
				$field_description['digest'] = 'sha1';
			}

			if($is_enum_set){
				$enum_set  = array('enum','set');
				$array_str = str_replace($enum_set,'array',$field->Type);
				$field_description['source'] = eval("return ".$array_str.";");
			}

			$fields[$field->COLUMN_NAME] = $field_description;
		}
		$this->_describe = $fields;
		return $fields; 
	}
}