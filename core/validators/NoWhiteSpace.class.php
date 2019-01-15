<?php defined('CORE') OR exit('No direct script access allowed');
class NoWhiteSpace extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		if (is_null($input)) { return true; }
		if (false === is_scalar($input)) { return false; }
		return !preg_match('#\s#', $input);
	}
}
