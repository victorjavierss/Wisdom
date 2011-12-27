<?php
/*
 This file is part of Wisdom.

 Wisdom is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or


 (at your option) any later version.

 Foobar is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the


 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 */

class Wisdom_DB {
	/**
	 * The PHP Data Object for stablish the connection to the database
	 * @var unknown_type
	 */
	protected $_pdo;
	/**
	 * The result set for a query
	 * @var unknown_type
	 */
	protected $_result_set;

	protected $_subject;

	protected $_schema;

	protected $_default_ports = array(
      'mysql'  => 3306,
      'oracle' => 1521,
      'oci'    => 1521,
      'mssql'  => 1433,
      'pgsql'  => 5432
	);

	protected $_rs;

	public function __construct($db_config){
		$dsn        = $this->doDSN($db_config);
		$this->_pdo = new PDO($dsn,$db_config['user'],$db_config['password']);
	}

	public function __destruct(){
		unset($this->_pdo);
	}

	function getTableClass(){
		return 'Wisdom_Db_Table';
	}


	/**
	 * @return PDO
	 */
	public function getPDO(){
		return $this->_pdo;
	}

	public function getSchema(){
		return $this->_schema;
	}

	/**
	 * Parses a DSN for the pdo conection
	 * @param unknown_type $ini
	 * @return unknown_type
	 */

	private function doDSN($db_config){
		$dsn  = $db_config['driver'];
		$name = $this->_schema = $db_config['name'];
		$host = $db_config['host'];
		$port = ( isset($db_config['port']) 
						&& is_numeric($db_config['port']) ) 
							? $db_config['port']
								: $this->_default_ports[$dsn] ;
		$user = $db_config['user'];
		$pass = $db_config['password'];

		 switch($db_config['driver']){
		 	case "mysql" : $dsn .=":dbname={$name};host={$host};port={$port}";break;
		 	case "oracle": $dsn  ="oci";
		 	case "oci"   : $dsn .=":dbname=//{$host}:{$port}/{$name}";break;
		 	case "mssql" : $dsn .=":host={$host}:{$port};dbname={$name}";break;
		 	case 'pgsql' : $dsn .=":host={$host};port={$port};dbname={$name};user={$user};password={$pass}";break;
		 	default      : $dsn ="mysql:dbname={$name};host={$host};port={$port}";break;
		 }
		return $dsn;
	}


	public function query($sql, $exec = TRUE){
		if($exec){
			$this->_rs = $this->_pdo->query($sql);
		}else{
			$this->_rs = $this->_pdo->exec($sql);
		}
	
		if ( $this->_rs  === false ){
			$error = $this->_pdo->errorInfo();
			throw new Exception($error[2], $error[1]);
		}
		
		return $this->_rs;
	}

	public function __call($function, $args){
		if( is_callable(array($this->_pdo,$function)) ){
			return call_user_func_array(array($this->_pdo,$function),$args);
		}else{
			throw new Exception("'{$function}' doesn't exists");
		}
	}

	/**
	 * Retrieves one record from a query
	 * @param $mode
	 * @return unknown_type
	 */
	public function fetchRow($mode = PDO::FETCH_OBJ){
		return (is_object($this->_rs) ) ? $this->_rs->fetch($mode) : FALSE;
	}

	/**
	 * @param $mode
	 * @deprecated
	 */
	public function fetch($mode = PDO::FETCH_OBJ){
		return $this->fetchRow($mode);
	}


	/**
	 * Fetch all the records from a query
	 * @param unknown_type $mode
	 * @return unknown_type
	 */
	public function fetchAll($mode = PDO::FETCH_OBJ){
		return $this->_rs->fetchAll($mode);
	}


	/**
	 * Retrieves the last inserted ID
	 * @return unknown_type the last inserted ID
	 */
	public function lastInsertId(){
		return $this->_pdo->lastInsertId();
	}
	
	public function rowCount(){
		return is_object($this->_rs) ? $this->_rs->rowCount() : 0; 
	}
}
?>