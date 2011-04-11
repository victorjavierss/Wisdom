<?php
class Wisdom_Db_Native_Wrapper{

	protected $_driver = 'mysql';
	protected $_link;
	protected $_resultset;
	protected $_table_class = 'Wisdom_Db_Table';

	const FETCH_ASSOC  = 'assoc';
	const FETCH_ARRAY  = 'array';
	const FETCH_OBJECT = 'object';

	function __construct($params){

		$native_connect = $this->_driver . "_connect";

		$this->_link = $native_connect($params['host'],$params['user'],$params['password']);
		if(!$this->_link){
			throw new Exception("No se pudo conectar a la BD");	
		}
		$native_select_db = $this->_driver . "_select_db";
		$native_select_db($params['name'], $this->_link);
	}

	function getLink(){
		return $this->_link;
	}

	function getTableClass(){
		return $this->_table_class;
	}

	function fetch($type = self::FETCH_OBJECT){
		$native_fetch = $this->_driver . '_fetch_' . $type;
		$return = $this->num_rows($this->_resultset) ? $native_fetch($this->_resultset) : FALSE;
		return $return;
	}

	function query($sql){
		$native_query = $this->_driver . "_query";
		$this->_resultset = $native_query($sql, $this->_link);		
		return $this->_resultset;
	}

	function fetchAll($type = self::FETCH_OBJECT){
		$results = array();
		while($result = $this->fetch($type)){
			$results [] = $result;
		}
		return $results;
	}


	function __call($func, $params){
		$native_func = $this->_driver . "_" . $func;
		return call_user_func_array($native_func, $params);
	}
}