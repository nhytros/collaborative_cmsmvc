<?php defined('CORE') OR exit('No direct script access allowed');
class PhpLabel extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		$rule = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';
		return is_string($input) && preg_match($rule, $input);
	}
}
