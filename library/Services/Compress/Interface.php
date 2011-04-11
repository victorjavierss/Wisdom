<?php

interface Services_Compress_Interface {
	
	public function close();
	public function addFile($file,$zip_name);
	public function addEmptyDir($path);
	public function extract($destination,$files = NULL);

}

?>
