<?php

if (! function_exists( 'get_called_class' ) ) {
    function get_called_class (){
        $t = debug_backtrace();
        $t = $t[1];
        if ( isset( $t['object'] ) && $t['object'] instanceof $t['class'] )
            return get_class( $t['object'] );
        return false;
    }
} 

/**
 * 
 * @param $haystack
 * @param $needle
 * @param $case
 * @deprecated
 */
function startsWith($haystack,$needle,$case=true) {
    return Wisdom_Utils::startsWith($haystack,$needle,$case);
}

/**
 * @param $haystack
 * @param $needle
 * @param $case
 * @deprecated
 */
function endsWith($haystack,$needle,$case=true) {
    return Wisdom_Utils::endsWith($haystack,$needle,$case);
}
/**
 * 
 * @param unknown_type $dir
 * @deprecated
 */
function getFilesFromDir($dir){
    return Wisdom_Utils::getFilesFromDir($dir);
}

function pre_dump($var){
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
}

class Wisdom_Utils{

   /**
   * @Deprecated
   */ 
   static function accesor(){
      return Wisdom_Utils::factory();
   }

    static function factory($class = FALSE){ 
        $object = new Wisdom_Factory();
        if( is_string($class) ) {
          $object = $object->get($class);
        }
        return $object;
    }
    
    
    static function startsWith($haystack,$needle,$case=true) {
        if($case){return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);}
        return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
    }
    
    static function endsWith($haystack,$needle,$case=true) {
        if($case){return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);}
        return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
    }
    
    static function getFilesFromDir($dir, $dirname_as_index = TRUE){
        $files=array();
        if(is_dir($dir)){
           $open = opendir($dir);
           while($file = readdir($open)){
              $path=$dir."/".$file;
              if( is_file($path) ){
              	  if($dirname_as_index){
                 	$files[ dirname($path) ][] = $file;
              	  }else{
              	  	$files[] = $file;
              	  }
              }
           }
        }
        natsort($files); 
        return $files;    
    }
    
    public static function getDirs($dir, $skip = array()){
    	$files = array();
    	if ( is_dir($dir) ){
    	$open = opendir($dir);
           while($file = readdir($open)){
              $path=$dir."/".$file;
              if( is_dir($path) && ! self::startsWith($file,'.') && ! in_array($file, $skip) ){
              	  $files[] = $path;
              }
           }
    	}else {
    		
    	}
    	
    	return $files;
    }
    
public static function jsCompress($files){
	
	$compressed_files = array();
	
	if( is_array ($files) ){
		foreach($files as $path=>$files){
			
			
			$min_path = $path . DIRECTORY_SEPARATOR . 'min'. DIRECTORY_SEPARATOR;

			if( !is_dir($min_path) ){
				mkdir($min_path, 0775);	
			}else{
				#ya existe el directorio donde se almacenan los js comprimidos
			}
			foreach($files as $file){
				if( ! is_file($min_path.$file) ){
					$compressed_file = fopen($min_path.$file, 'w+');
					$min_js          = Wisdom_Jsmin::minify( file_get_contents($path."/".$file) );
					fwrite($compressed_file, $min_js);
	           		fclose($compressed_file);
				} else {
					#Javascript file is already compressed
				}
				$compressed_files [] = 'min/'.$file;
			}
		}
	}else{
		throw new Exception("No files for compress");
	}
	
	//Regresar el path de todos los archivos
    return $compressed_files;
}
    public static function deleteArrayElements(&$array, array $unwanted_values){
    	
    	foreach($unwanted_values as $unwanted_value){
    		$array = preg_grep("/$unwanted_value/",$array,PREG_GREP_INVERT);
    	}
    	
    }
    
	public static function deleteArrayElementsByKey(&$array, array $unwanted_keys){
		
    	foreach($unwanted_keys as $unwanted_key){
    		unset($array[$unwanted_key]);
    	}
    	
    }
}


?>
