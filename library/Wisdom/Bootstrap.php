<?php
ob_start();
session_start();

$uri= substr($_SERVER["SCRIPT_NAME"],0,strripos($_SERVER["SCRIPT_NAME"],"/"));

date_default_timezone_set('America/Chicago');
 
define("URL","http://".$_SERVER["HTTP_HOST"].$uri."/");

if (! defined('MODULES_PATH')){
	//Modules PATH
	define('MODULES_PATH',APP_HOME.'/module');
}
 
if (! defined('JAVASCRIPT_PATH')){
	//Javascript PATH
	define('JAVASCRIPT_PATH','/js');
}
 
if (! defined('FILES_PATH')){
	//Files PATH
	define('FILES_PATH','files');
}
 

if (! defined('WISDOM_WIDGETS')){
	//Determinates if JS compression is enabled
	define('WISDOM_WIDGETS',WISDOM_HOME . '/Widgets');
}

$services_path = WISDOM_HOME  . '/services';
$wisdom_common = WISDOM_HOME  . '/common';
$app_library   = APP_HOME     . '/library';
$app_common    = APP_HOME     . '/common';
$app_widgets   = APP_HOME     . '/Widgets';
 
$include_path  = MODULES_PATH   . PATH_SEPARATOR .
$app_library   . PATH_SEPARATOR .
$app_common    . PATH_SEPARATOR .
WISDOM_LIB     . PATH_SEPARATOR .
$wisdom_common . PATH_SEPARATOR .
WISDOM_WIDGETS . PATH_SEPARATOR .
$services_path;

set_include_path( $include_path . PATH_SEPARATOR . get_include_path());


$config = Wisdom_Utils::factory('Wisdom_Config');

if (! defined('DEFAULT_MODULE')){
	$default_module = $config->app['home_controller'];
	if( ! $default_module ){
		throw new Exception('No default module was given');
	}
	define('DEFAULT_MODULE',$default_module);
}

if (! defined('JS_COMPRESS')){
	//Determinates if JS compression is enabled
	$compress_js = isset($config->app['compress_js']) ? $config->app['compress_js'] : 0;
	define('JS_COMPRESS',$compress_js);
}

if (! defined('DEBUG')){
	//Whether print debug infomation or not (1=debug,0=no debug)
	$debug = isset($config->app['debug']) ? $config->app['debug'] : 0;
	define('DEBUG', $debug);
}

$displayErrors = DEBUG ? 1:0;
ini_set("display_errors", 1);


if ( ! defined('APP_NAME') ){
	$nombre_app = isset($config->app['name']) ? $config->app['name'] : 'Sin nombre';
	define('APP_NAME',$nombre_app);
}
 
if (! defined('THEME_PATH')){
	define('THEME_PATH','/theme');
}

if (! defined('CHECKUSER')){
	//Checks wheter a user is loged in (1=yes,0=no)
	$checkuser = isset($config->app['checkuser']) ? $config->app['checkuser'] : 1;
	define('CHECKUSER', $checkuser);
}

$preferences = Wisdom_Utils::factory('Wisdom_Preferences_Adapter');
Wisdom_Preferences::loadAdapter($preferences);

function __autoload($class_name){
	$class = str_replace('_',DIRECTORY_SEPARATOR,$class_name);
	$file = $class . '.php';
	if ($fh = @fopen($file, 'r', true)) {
        include_once $file;
    }
    @fclose($fh);
}
