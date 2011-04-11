<?php
class Wisdom_DB_Admin {
  
    private static $_conexiones_base_datos = NULL;
    
    const CONEXION_DEFAULT = 'default';
    protected static $_default_class = 'Wisdom_Db';
    
	/**
	 * @param string $conexion Nombre de la conexión en .ini
	 * @return Wisdom_DB
	 */
  public static function getConexion($conexion = self::CONEXION_DEFAULT ){
  	
  	
     if ( ! isset(self::$_conexiones_base_datos[$conexion]) ){
         $db_config = Wisdom_Config::get($conexion,'db');
         
         $params [] = $db_config;
         $class = (isset($db_config['class']) && $db_config['class'])  ? $db_config['class'] : self::$_default_class;
         self::$_conexiones_base_datos[$conexion] = Wisdom_Utils::accesor()->get($class,$params);
     }
     return self::$_conexiones_base_datos[$conexion];
  }
}
