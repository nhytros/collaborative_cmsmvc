<?php defined('CORE') OR exit('No direct script access allowed');
class ErrorController extends Controller {
	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
	}

	public function index() {
		$this->view->render('error/restricted');
	}

	public function badToken() {
		$this->view->render('error/badToken');
	}
}
