<?php defined('CORE') OR exit('No direct script access allowed');
class Anuls extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		$rule = '/^(\s|[a-zA-Z0-9!@#$%^&*()\-_=+{};:,<.>])*$/';
		return preg_match($rule, $input);
	}
}
