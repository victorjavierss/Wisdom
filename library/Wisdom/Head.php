<?php

class Wisdom_Head{
    
    public static function metas(){
        include_once(CONFIG_PATH."/head.inc");
        static $html_head = null;
        
        if(!$html_head){
        $html_head   = "<meta http-equiv='content-type' content='application/xhtml+xml; charset=UTF-8' />\n";
        $author = FALSE;
        $done   = FALSE;
        
        !isset($metas) && $metas = array();
	        foreach($metas as $meta){
	            $html_head.='<meta';
	            foreach($meta as $attribute=>$value){
	               if(strtolower($value)=="author"){
	                 $author=TRUE;      
	               }
	               if(!$done && $author && $attribute=='content' ){
	                   $value.=' - Wisdom Toolkit';
	                   $done=TRUE;
	               }
	               $html_head.=" {$attribute}='{$value}'";
	            }            
	            $html_head.=" />";
	        }
	        !$author && $html_head .= "<meta name='author' value='Wisdom Toolkit'/>";
	        $request = Wisdom_Utils::factory('Wisdom_Request');
	        $controller = strtolower($request->controller);
	        $action     = ($display=strtolower($request->action)=='display') ? '' : ucfirst($request->action);
	        
	        $controller = $display ? ucfirst($request->controller) :strtolower($request->controller);
	        
	        $html_head .= "<title>.:: " . APP_NAME . " - {$action} {$controller} ::.</title>";
        }
        return $html_head;
    }
    
    public static function css($widget = NULL){
        $style = Wisdom_Utils::factory("Wisdom_Head_Style");
        if($widget){
        	#CSS del widget
        	$style->addWidgetStyle($widget);
        }else{
        	#CSS de wisdom
        	$style->addCoreStyle();
        	#CSS del sistema
        	$style->addAppStyle();
        }
        return $style;
    }
    
    public static function js($widget = NULL){
        $js_link="";
        
        if($widget){
        	#Cargar los JS del widget
        	$js_widget = Wisdom_Utils::getFilesFromDir(WISDOM_WIDGETS . "/{$widget}/js", JS_COMPRESS ? TRUE : FALSE );
        	
        	if(JS_COMPRESS){
        		$js_widget = Wisdom_Utils::jsCompress($js_widget);
        	}else {
        		#No se requiere compresión
        	}        	
        	
            foreach($js_widget as $js){
               $js_link.="<script type='text/javascript' src='".URL."../wisdom/Widgets/{$widget}/js/{$js}'> </script>\n";
            }
            
        }else{
        	#Loads Wisdom Javascript
			  $js_wisdom = Wisdom_Utils::getFilesFromDir(WISDOM_HOME."/js",JS_COMPRESS ? TRUE : FALSE );

			  if(JS_COMPRESS){
			  	$js_wisdom = Wisdom_Utils::jsCompress($js_wisdom);
			  }
	          foreach($js_wisdom as $js){
	             $js_link.="<script type='text/javascript' src='".URL."../wisdom/js/{$js}'> </script>\n";
	          }

	          $js_app = Wisdom_Utils::getFilesFromDir(APP_HOME."/js",JS_COMPRESS ? TRUE : FALSE);
        	  if(JS_COMPRESS){
			  	$js_app = Wisdom_Utils::jsCompress($js_app);
			  }
			foreach($js_app as $js){  
	          $js_link.="<script type='text/javascript' src='".URL.JAVASCRIPT_PATH."/{$js}'> </script>\n";
	        }
			
        	
        }
        return $js_link;
    }    
	
	public static function renderMessageQueue(){
		
	    $message_queue = isset($_SESSION['message_queue']['messages']) ?  $_SESSION['message_queue']['messages'] : FALSE;
		if ( $message_queue ){
			$messages = "<script typpe='text/javascript'>
				window.addEvent('domready',function(){
			";
			
			foreach ($message_queue as $message  ){
				$messages .= "JS_Growl.notify('$message');";
			}

			$messages .= "});</script>";
			
			$_SESSION['message_queue']['messages'] = array();
		}else{
			$messages="";
		}
		return $messages;
	}
}

?>
