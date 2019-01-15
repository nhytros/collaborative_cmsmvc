<?php defined('CORE') OR exit('No direct script access allowed');
class Punct extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		return ctype_punct($input);
	}
}
