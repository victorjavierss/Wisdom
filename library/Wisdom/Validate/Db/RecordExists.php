<?php

class Wisdom_Validate_Db_RecordExists implements Wisdom_Validate_Interface {
	
	protected $_table = '';
	
	protected $_field = '';
	
	protected $_row   = NULL;
	
	public function __construct($table, $field, $ignore=TRUE){
		$this->_table = $table;
		$this->_field = $field; 	
	}
	
	public function isValid($value, $context=array()){
		$table = new Wisdom_Db_Table();
		$table->setName($this->_table);
		
		$select = $table->select()
						->where("{$this->_field} = ?", $value);

		$this->_row = $row = $table->fetchRow($select);
		
		return (bool)$row;
	}
}
