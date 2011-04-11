<?php
class Helpers_Partial extends Wisdom_Helper{
	public function partial( $file, $vars ){
		Wisdom_View::element($file, APP_HOME . '/common/partials', $vars);
	}
}