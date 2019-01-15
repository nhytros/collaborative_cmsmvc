<?php defined('CORE') OR exit('No direct script access allowed');
class Roman extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		$rule = '/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/';
		if (!is_scalar($input)) {return false;}
		return (bool) preg_match($rule, $input);
	}
}
