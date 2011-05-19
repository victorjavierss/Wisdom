<?php
class Wisdom_Db_Admin {
  
    private static $_conexiones_base_datos = NULL;
    
    const CONEXION_DEFAULT = 'default';
    protected static $_default_class = 'Wisdom_Db';
    
	/**
	 * @param string $conexion Nombre de la conexión en .ini
	 * @return Wisdom_Db
	 */
  public static function getConexion($conexion = self::CONEXION_DEFAULT ){
  	
  	
     if ( ! isset(self::$_conexiones_base_datos[$conexion]) ){
         $db_config = Wisdom_Config::get($conexion, 'db');
         if($db_config){
	         $params [] = $db_config;
	         $class = (isset($db_config['class']) && $db_config['class'])  ? $db_config['class'] : self::$_default_class;
	         self::$_conexiones_base_datos[$conexion] = Wisdom_Utils::accesor()->get($class,$params);
         }else{
         	throw new Exception('No connection arguments provided');
         }
     }
     return self::$_conexiones_base_datos[$conexion];
  }
  
  public static function shutdown(){
  	foreach(self::$_conexiones_base_datos as $key_connection=>$connection){
  		unset(self::$_conexiones_base_datos[$key_connection]);
  	}
  	unset($connection);
  }
}
