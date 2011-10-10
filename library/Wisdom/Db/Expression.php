<?php
class Wisdom_Db_Expression{
	protected $_expression;
	public function __construct($expression){
		$this->_expression = $expression;
	}
	public function __toString(){
		return $this->_expression;
	}
	
}