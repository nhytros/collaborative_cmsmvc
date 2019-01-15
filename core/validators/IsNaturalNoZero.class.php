<?php defined('CORE') OR exit('No direct script access allowed');
class IsNaturalNoZero extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		$rule = '/^[1-9]+$/';
		return (preg_match($rule,$input));
	}
}
