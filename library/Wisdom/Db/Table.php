<?php

class Wisdom_Db_Table  {

	protected $_name    = NULL;
	protected $_primary = NULL;
	protected $_schema  = NULL;

	protected  $_describe = NULL;
	protected  $_db;

	protected $_data_type_validations = array(
	                                      'char'    => 'alphanumeric',
	                                      'text'    => 'alphanumeric',
	                                      'binary'  => 'alphanumeric',
	                                      'blob'    => 'alphanumeric',
	                                      'int'     => 'int',
	                                      'decimal' => 'numeric',
	                                      'double'  => 'numeric',
	                                      'float'   => 'numeric',     
	                                      'enum'    => 'source',
	                                      'set'     => 'source'
	                               );
	                               
	public function setName($name){
		$this->_name = $name;
	}

	public function getName(){
		return $this->_name;
	}

	public function setPrimary($primary){
		$this->_primary = $primary;
	}

	public function getPrimary(){
		return $this->_primary;
	}
	
	public function setSchema($schema){
		$this->_schema = $schema;
	}

	public function __construct($conexion = Wisdom_Db_Admin::CONEXION_DEFAULT){
		$conexion  = ($conexion instanceof Wisdom_Db_Interface) ? $conexion 
															: Wisdom_Db_Admin::getConexion($conexion);
		$this->setConexion($conexion);
	}


	public function setConexion($conexion){
		$this->_db = $conexion;
	}

	public function fetchRow($select = NULL, $mode = PDO::FETCH_OBJ ){
		$this->query($select);
		return $this->_db->fetch($mode);
	}

	public function fetchAll($select = NULL){
		if ( is_null($select) ){
			$this->_db->select(array($this->_name=>array('fields'=>"*")), NULL, TRUE);
		}else{
			$this->_db->query((string)$select, true);
		}
	
		return $this->_db->fetchAll();
	}
	
	public function query($select){
		if($select instanceof Wisdom_Db_Select){
			$sql = (string) $select;
		} elseif (is_string($select)){
			$sql = $select;
		}else{
			throw new Exception("'{$select}' is not a valid query");
		}
		$this->_db->query($sql);
	}

	public function find($id){
		$select = Wisdom_Utils::factory()->get("Wisdom_Db_Select",array($this->getName()));
		$primary = $this->getPrimary();
		$select->where(" {$primary} = ?",$id);
		return $this->fetchRow($select);
			
	}

	public function describe(){
		$sql = "DESCRIBE {$this->_name}";
		$this->_db->query($sql, TRUE);

		$fields = array();
		
		while($field = $this->_db->fetch()){
			$field_description['label'] = str_replace('id_','',$field->Field);

			$is_enum_set = FALSE;

			if($field->Field == 'email' ){
				$field_description['validate'] = 'email';
			} else{
				foreach($this->_data_type_validations as $type=> $validation){
					if(preg_match("/{$type}/",$field->Type)){
						if( $type=='enum' || $type=='set' ){
							$is_enum_set = TRUE;
						}
						$field_description['validate'] = $validation;
						break;
					}
				}
			}

			if($field->Field == 'password' || $field->Field == 'psw' ){
				$field_description['type']   = 'password';
				$field_description['digest'] = 'sha1';
			}

			if($is_enum_set){
				$enum_set  = array('enum','set');
				$array_str = str_replace($enum_set,'array',$field->Type);
				$field_description['source'] = eval("return ".$array_str.";");
			}

			$fields[$field->Field] = $field_description;
		}
		$this->_describe = $fields;
		return $fields; 
	}

	/**
	 * Inserts data to a table
	 * @param $table The table you want to insert the data
	 * @param $data The data to inserte in the table
	 * @return unknown_type
	 */

	public function insert(array $data){
		$fields = array_keys($data);

		$table = $this->getName();

		$this->scape($data);

		$fields = implode(',', $fields);
		$values = implode(',', $data);

		$sql = "INSERT INTO ".$table." (".$fields.") VALUES (".$values.")";

		return $this->_db->query($sql);
	}

	public function getFields(){
		return $this->_describe;
	}
	
	private function scape(& $data){
		foreach($data as &$value){
			$value = "'{$value}'";
		}
		unset($value);
	}
	
	public function rowCount(){
		return $this->_db->rowCount();
	}
	
	public function select(){
		return Wisdom_Utils::factory()->get("Wisdom_Db_Select",array( $this->_table ))->select();
	}
	
	public function __toString(){
		return $this->_name;
	}
	
	public function lastId(){
		return $this->_db->lastInsertId();
	}
}