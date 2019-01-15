<?php defined('CORE') OR exit('No direct script access allowed');
class Config{
	protected static $settings = [];

	public static function get($key) { return isset(self::$settings[$key]) ? self::$settings[$key] : null; }
	public static function exists($key) { return isset(self::$settings[$key]) ? true : false; }
	public static function set($key,$value) { self::$settings[$key] = $value; }
}
