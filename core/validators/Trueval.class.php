<?php defined('CORE') OR exit('No direct script access allowed');
class Trueval extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		return (true === filter_var($input,FILTER_VALIDATE_BOOLEAN,FILTER_NULL_ON_FAILURE));
	}
}
