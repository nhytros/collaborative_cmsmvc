<?php defined('CORE') OR exit('No direct script access allowed');
class ExactLength extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		return (strlen($input) == $this->rule);
	}
}
