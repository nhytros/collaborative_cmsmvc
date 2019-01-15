<?php defined('CORE') OR exit('No direct script access allowed');
class Controller extends App {
	protected $_controller, $_action;
	public $view, $request;

	public function __construct($controller, $action) {
		parent::__construct();
		$this->_controller = $controller;
		$this->_action = $action;
		$this->request = new Input();
		$this->view = new View();

		// if (!Config::exists('site_url') || empty(config('site_url'))) {
		// 	if(isset($_SERVER['SERVER_ADDR'])) {
		// 		if(strpos($_SERVER['SERVER_ADDR'],':') !== false) {
		// 			$server_addr = '['.$_SERVER['SERVER_ADDR'].']';
		// 		} else {
		// 			$server_addr = $_SERVER['SERVER_ADDR'];
		// 		}
		// 		$base_url = (is_https() ? 'https':'http').'://'.$server_addr
		// 			.substr($_SERVER['SCRIPT_NAME'],0,strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_NAME'])));
		// 	} else {
		// 		$base_url = 'http://localhost/';
		// 	}
		// 	Config::set('site_url', $base_url);
		// }
	}

	protected function load_model($model) {
		if(is_array($model)) {
			foreach($model as $m) { self::load($m); }
		} else { self::load($model); }
	}

	protected function load($model) {
		if (class_exists($model)) {
			$this->{$model.'Model'} = new $model(strtolower($model));
		}
	}
}
