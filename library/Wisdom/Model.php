<?php
class Wisdom_Model {
	
	protected $_db_table    = NULL;
	
	protected $_table       = NULL;
	protected $_primary_key = NULL;
	protected $_conexion    = Wisdom_Db_Admin::CONEXION_DEFAULT;
	protected $_ref_cols    = array();

	protected $_errors      = array();
	
	public function __construct(){

		if( is_null($this->_table )){
			throw new Exception('No table especified for model: ' . get_called_class() );
		}

		$conexion = Wisdom_Db_Admin::getConexion($this->getConexion());
		
		$class = $conexion->getTableClass();
		
		$this->_db_table = Wisdom_Utils::factory()->get($class, array($this->getConexion()));
		
		$this->setName( $this->_table );
		$this->setPrimary( $this->getPrimary() );
		$this->describe();
		
		$this->init();
	}

	public function getErrors(){
		return $this->_errors;
	}
	
	/**
	 * Custom action for initialize de model
	 */
	public function init(){}

	/**
	 * Validates if the given data is valid according to the $_Validate array
	 * @param unknown_type $data data to validate
	 * @return unknown_type True if the data is valid, false otherwise
	 */
	protected function isValid($data){
		$valid = TRUE;
	  
		return $valid;
	}

	/**
	 * Saves a record in the database
	 * @param unknown_type $data
	 * @return unknown_type
	 */
	public function save($data){
		if($this->isValid($data)){
			$result = $this->_db_table->insert($data);
		}else{
			$result = FALSE;
		}
		return $result;
	}

	public function getTable(){
		return $this->_db_table;
	}

	public function fetchAll($select = NULL){
		if ( is_null($select) ){
			$select = $this->getSelect();
		}
		return $this->_db_table->fetchAll($select);
	}

	public function getConexion(){
		return $this->_conexion;
	}


	public function getPrimary(){
		return $this->_primary_key;
	}

	public function getSelect(){
		return Wisdom_Utils::factory()->get("Wisdom_Db_Select",array( $this->_table ))->select();
	}


	public function __call($function, $args){
		if( is_callable(array($this->_db_table, $function)) ){
			return call_user_func_array(array($this->_db_table,$function),$args);
		}else{
			throw new Exception("Unknow function '{$function}");
		}
	}
}
