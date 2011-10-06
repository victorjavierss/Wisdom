<?php
class Wisdom_Db_Row  {

	protected $_id    = NULL;
	protected $_table = NULL;
	protected $_data  = NULL;
	protected $_updated = NULL;

	
	public function __construct($table, $data = array()){
		if( is_string($table) ){
			$table = Wisdom_Utils::factory($table);
		}
		
		if ($table instanceof Wisdom_Db_Table){
			$this->_table = $table;
		}else{
			throw new Exception("'". get_class($table)."' is not a instance of Db_Table");
		}

		if( is_array($data) ){
			$this->setData($data);
		}else{

		}
	}
	
	public function load($id){
		$loaded = (bool) $data = $this->_table->find($id);
		$data = Wisdom_Utils::objectToArray($data);
		$this->setData($data);
		$this->_id = $id;
		return $loaded;
	}

	public function save(){
		if( ! $this->_id ){
			$result = $this->_table->insert($this->_data);
			
			$this->_data[ $this->_table->getPrimary() ] = $this->_id = $this->_table->lastId();
		}else{
			$primary = $this->_table->getPrimary();
			$result = $this->update($this->_updated, "WHERE {$primary} ='{$this->_id}'");
		}
		return $result;
	}	

	/**
	 * Updates a record from a table
	 * @param unknown_type $table The table you want to update
	 * @param array $data The data you want to update
	 * @param unknown_type $condition The condition for performs the updating, if none especified all records are updated
	 * @return unknown_type
	 */
	protected function update(array $data, $condition=""){
		$update = array();
		foreach($data as $campo=>$valor){
			if($valor instanceof Wisdom_Db_Expression ){
				$valor = $valor;
			}else{
				$valor = "'".$valor."'";
			}
			$update[] = "{$campo}={$valor}";
		}
		$update = implode(',',$update);

		$table = (string) $this->_table;

		$sql = "UPDATE {$table} SET {$update} {$condition}";
		return $this->_table->query( $sql );
	}

	public function toArray(){
		return $this->_data;
	}

	public function setData($data){
		$this->_data = $data;
		$primary = $this->_table->getPrimary();
		$this->_id   = isset($data[$primary]) ? $data[$primary] : FALSE;
	}

	public function __get($var){
		$value = isset($this->_data[$var]) ? $this->_data[$var] : FALSE;
		if($value){
			if ( @iconv( 'UTF-8', "UTF-8//TRANSLIT", $value) == $value ){
				
			}else{
				$value = utf8_encode ($value);
			}
		}
		return $value;
	}
	
	public function __set($var, $value){
		$this->_data[$var] = $this->_updated[$var] = $value;
	}
}