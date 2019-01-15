<?php defined('CORE') OR exit('No direct script access allowed');
class IsNatural extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		$rule = '/^[0-9]+$/';
		return (preg_match($rule,$input));
	}
}
