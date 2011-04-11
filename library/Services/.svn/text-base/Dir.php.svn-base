<?php
class Services_Dir{
	
	public function showInfo(){
	
	}
	
	public function ls($dir){
		$ls = array();
		try {
			$ri = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, 0));
			 
			while($ri->valid())
			{
				if(!$ri->isDot()) {
					$ls[] = $ri->getPathName();
				} else {
				}
				$ri->next();
			}

		} catch (Exception $e) {
			throw new Exception ("Permisos de lectura insuficientes para obtener informacion del directorio especificado");
		}

		return $ls;
	}
}
