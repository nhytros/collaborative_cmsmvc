<?php defined('CORE') OR exit('No direct script access allowed');
class Cookie{
	public static function exists($name) { return isset($_COOKIE[$name]); }
	public static function isEmpty($name) { return empty($_COOKIE[$name]); }
	public static function get($name) { return $_COOKIE[$name]; }
	public static function set($name, $value, $expiry) { return (setcookie($name, $value, time()+$expiry, '/')) ? true : false; }
	public static function delete($name) { self::set($name,'',time()-1); }
}
