<?php
class Wisdom_Db_MsSql extends Wisdom_Db_Native_Wrapper{
	protected $_driver = 'mssql';
	protected $_table_class = 'Wisdom_Db_MS_Table';
	
	function fetch($type = self::FETCH_OBJECT){
		return parent::fetch($type);
	}
}