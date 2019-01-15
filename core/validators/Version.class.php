<?php defined('CORE') OR exit('No direct script access allowed');
class Version extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		$rule = '/^[0-9]+\.[0-9]+\.[0-9]+([+-][^+-][0-9A-Za-z-.]*)?$/';
		if (!is_scalar($input)) {return false;}
		return (bool) preg_match($rule, $input);
	}
}
