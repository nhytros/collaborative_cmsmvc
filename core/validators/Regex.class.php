<?php defined('CORE') OR exit('No direct script access allowed');
class Regex extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		if (!is_scalar($input)) {return false;}
		return (bool) preg_match($this->rule, $input);
	}
}
