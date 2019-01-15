<?php defined('CORE') OR exit('No direct script access allowed');
class Roman extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		$rule = '/^y(eah?|ep|es)?$/i';
		if (!is_scalar($input)) {return false;}
		return (bool) preg_match($rule, $input);
	}
}
