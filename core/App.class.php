<?php defined('CORE') OR exit('No direct script access allowed');
class App {
	public $app;

	public function __construct() {
		$this->_set_reporting();
		$this->_unregister_globals();
	}

	private function _set_reporting() {
		switch (Config::get('mode')) {
			case 'development':
			case 'devel':
			case 'd':
			error_reporting(-1);
			ini_set('display_errors', 1);
			break;
			case 'production':
			case 'prod':
			case 'p':
			ini_set('display_errors', 0);
			ini_set('log_errors', 1);
			ini_set('error_log',LOGSPATH.'errors.log');
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
			break;
			default:
			header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
			echo 'The application environment is not set correctly.';
			exit();
		}
		$this->app = Config::get('mode');
	}

	private function _unregister_globals() {
		if (ini_get('register_globals')) {
			$globalsArray = ['_SESSION','_COOKIE','_POST','_GET','_REQUEST','_SERVER','_ENV','_FILES','GLOBALS','HTTP_RAW_POST_DATA'];
			foreach ($globalsArray as $g) {
				foreach ($GLOBALS[$g] as $key => $val) {
					if ($GLOBALS[$key] === $val) {
						unset($GLOBALS[$key]);
					}
				}
			}
		}
	}
}
