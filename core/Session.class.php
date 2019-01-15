<?php defined('CORE') OR exit('No direct script access allowed');
class Session{
	public static function init() { if(!isset($_SESSION)) { session_start(); } }
	public static function exists($key) { return (isset($_SESSION[$key])) ? true : false; }
	public static function get($key) { return (isset($_SESSION[$key])) ? $_SESSION[$key] : null; }
	public static function set($key, $val) { $_SESSION[$key] = $val; }
	public static function regenID() { if(isset($_SESSION)) {session_regenerate_id();} }
	public static function kill($key) { if(self::exists($key)) { unset($_SESSION[$key]); } }
	public static function uagentNoVersion() { return preg_replace('/\/[a-zA-Z0-9.]+/','',$_SERVER['HTTP_USER_AGENT']); }
	public static function flash($type, $message, $redirect) { self::set($type,$message);redirect($redirect); }
	public static function checkFlash() {
		$warnings = ['danger','warning','success','info'];
		if (self::exists('danger') || self::exists('warning') || self::exists('success') || self::exists('info')) {
			vd($_SESSION);
			echo '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">';
			echo '<ul>';
			foreach($warnings as $type) {
				if(is_array(self::get($type))) {
					echo '<li class="text-'.$type.'">'.self::get($type[0]).'</li>';
				} else {
					echo '<li class="text-'.$type.'">'.self::get($type).'</li>';
				}
			}
			echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
			echo '<span aria-hidden="true">&times;</span></button></div>';
			self::kill($type);
		} else {
			return null;
		}
	}
}
//
// $html = '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">';
// $html .= '<ul>';
// foreach($this->_errors as $error) {
// 	if(is_array($error)) {
// 		$html .= '<li class="text-'.$type.'">'.$error[0].'</li>';
// 		// $html .= '<script>jQuery("document").ready(function(){jQuery("#'.$error[1].'").parent().closest("div").addClass("has-error")})</script>';
// 	} else {
// 		$html .= '<li class="text-'.$type.'">'.$error.'</li>';
// 	}
// }
// $html .= '</ul></div>';
