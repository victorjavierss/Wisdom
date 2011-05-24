<?php

class Wisdom_Db_Select  {

       private $_table   = null;
       private $_joins   = null;
       private $_fields  = null;
       private $_where   = null;
       private $_limit   = null;
       private $_group_by = null;
       
       function __construct($table=null) {
               $this->from($table);
       }
       
       public function select($fields = "*"){
               if(is_array($fields)){
                       $this->_fields = implode(',',$fields);
               }elseif(is_string($fields)){
                       $this->_fields = $fields;
               }else{
                       $this->_fields = "*";
               }
               return $this;
       }
       
       public function from($table){
               $this->_table = $table;
       }
       
       public function where($prepared, $value=null){
               $this->_where [] = str_replace('?',"'{$value}'",$prepared);
               return $this;
       }
       
       public function leftJoin($table,$on_t ,$on_i){
               throw new Exception ("Not yet implemented");
       }
       
       public function rigthJoin($table,$on_t ,$on_i){
               throw new Exception ("Not yet implemented");
       }
       
       public function innerJoin($table, $on){
               $this->_joins[] = "INNER JOIN {$table} ON {$on}";
			   return $this;
       }
       
       public function limit($init, $length = NULL){
               $this->_limit = " LIMIT {$init}";
               if( is_numeric($length) ){
                       $this->_limit .= ",{$length}";
               }else{
                       #No limit
               }
               return $this;
       }

       public function groupBy($field){
               $this->_group_by[] = $field;
               return $this;
       }
       
       private function _buildSQL(){
               $fields = $this->_fields ? $this->_fields : '*';
               $sql = "SELECT {$fields} FROM {$this->_table} ";
               
               is_array($this->_joins) && $sql.=implode(" ", $this->_joins);

               if ( is_array($this->_where) && !empty($this->_where) ){
                       $where = implode(" AND ",$this->_where);
                       $sql .= " WHERE {$where}";
               }else{
                       #No where
               }
               if(is_array($this->_group_by) && !empty($this->_group_by)){
                       $sql .= " GROUP BY " . implode(',',$this->_group_by);
               }

			   $sql .= $this->_limit;

               return $sql;
       }
       
       public function __toString(){
               return $this->_buildSQL();
       }
}

?>
