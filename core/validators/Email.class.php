<?php defined('CORE') OR exit('No direct script access allowed');
class Email extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		return (filter_var($input,FILTER_VALIDATE_EMAIL));
	}
}
