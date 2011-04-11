<?php

class Wisdom_Db_Row  {

	protected $_id    = NULL;
	protected $_table = NULL;
	protected $_data  = NULL;

	
	public function __construct($table, $data){
		
		if( is_string($table) ){
			$this->_table = Utils::factory($table);
		}elseif ($table instanceof Db_Table){
			$this->_table = $table;
		}else{
			throw new Exception("'{$table}' is not a instance of Db_Table");
		}

		if( is_array($data) ){
			$this->_data = $data;
		}else{
			
		}

	}
	
	//	delete
	//	update

	 
	/**
	 * Updates a record from a table
	 * @param unknown_type $table The table you want to update
	 * @param array $data The data you want to update
	 * @param unknown_type $condition The condition for performs the updating, if none especified all records are updated
	 * @return unknown_type
	 */
	public function update(array $data,$condition=""){
		$update = array();
		foreach($data as $campo=>$valor){
			$update[] = "{$campo}='".htmlentities($valor)."',";
		}
		$update = implode(',',$update);
		if($condition != ""){
			$condition="WHERE ".$condition;
		}
		$this->query("UPDATE {$table} SET {$update} {$condition}" );
	}

	public function toArray(){
		return $this->_data;
	}
}

?>
