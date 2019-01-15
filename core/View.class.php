<?php defined('CORE') OR exit('No direct script access allowed');
class View {
	protected $_head, $_body, $_footer, $_block, $_pageTitle, $_outputBuffer, $_layout;

	public function __construct() {
		$this->_pageTitle = Config::get('default_page_name');
		$this->_layout    = Config::get('default_layout');
		$this->post       = ($_POST)?($_POST):'';
	}

	public function render($viewName) {
		$viewArray = explode('/', $viewName);
		$viewString = implode(DS, $viewArray);
		if(file_exists(VIEWS.$viewString.'.php')) {
			include VIEWS.$viewString.'.php';
			include LAYOUTS.$this->_layout.'.php';
		} else {
			die('The view <em><b>'.$viewName.'</b></em> does not exists');
		}
	}

	public function template($tplName) {
		$tplArray = explode('/', $tplName);
		$tplString = implode(DS, $tplArray);
		if(file_exists(LAYOUTS.$tplString.'.php')) {
			include LAYOUTS.$tplString.'.php';
		} else {
			die('The template <em><b>'.$tplName.'</b></em> does not exists');
		}
	}

	public function content($type) {
		switch (strtolower($type)) {
			case 'head': return $this->_head; break;
			case 'body': return $this->_body; break;
			case 'footer': return $this->_footer; break;
			case 'block': return $this->_block; break;
			default: return false; break;
		}
	}

	public function start($type) {
		$this->_outputBuffer = $type;
		ob_start();
	}

	public function end() {
		switch (strtolower($this->_outputBuffer)) {
			case 'head': $this->_head = ob_get_clean(); break;
			case 'body': $this->_body = ob_get_clean(); break;
			case 'footer': $this->_footer = ob_get_clean(); break;
			case 'block': $this->_block = ob_get_clean(); break;
			default: die('You must first run the start method.'); break;
		}
	}

	public function insert($path) {
		if (file_exists(VIEWS.$path.'.php')) {
			include VIEWS.$path.'.php';
		} else {
			die("File ".$name." non trovato");
		}
	}

	public function partial($group, $partial) {
		$path = $group.DS.'partials'.DS.$partial;
		self::insert($path);
	}

	public function block($name) {
		if (file_exists(VIEWPATH.'layouts/blocks/'.$name.'.php')) {
			include VIEWPATH.'layouts/blocks/'.$name.'.php';
		} else {
			die("Block ".$name." not found");
		}
	}

	// public function post($item) { return ($_POST[$item]) ? $_POST[$item] : ''; }
	public function pageTitle() { return $this->_pageTitle; }
	public function setPageTitle($title) { $this->_pageTitle = ($title) ? Config::get('default_page_name').' | '. $title : $this->_pageTitle; }
	public function setLayout($path) { $this->_layout = $path; }
}
