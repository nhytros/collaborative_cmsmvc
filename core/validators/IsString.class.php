<?php defined('CORE') OR exit('No direct script access allowed');
class IsString extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		return (is_string($input));
	}
}
