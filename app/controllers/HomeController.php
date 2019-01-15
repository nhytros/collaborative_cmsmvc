<?php defined('CORE') OR exit('No direct script access allowed');
class HomeController extends Controller {
	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
	}

	public function index() {
		$this->view->render('home/index');
	}

	public function lang($lng) {
		Session::kill('lang');
		Session::set('lang',$lng);
		// Session::set('lang','en');
		redirect('prev');
	}
}
