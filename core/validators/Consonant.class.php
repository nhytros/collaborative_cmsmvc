<?php defined('CORE') OR exit('No direct script access allowed');
class Vowel extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		$rule = '/^(\s|[BCDFGHJKLMNPQRSTVWXYZbcdfghjklmnpqrstvwxyz])*$/';
		return (bool) preg_match($rule, $input);
	}
}
