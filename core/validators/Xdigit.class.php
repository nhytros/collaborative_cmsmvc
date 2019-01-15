<?php defined('CORE') OR exit('No direct script access allowed');
class Xdigit extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		return (ctype_xdigit($input));
	}
}
