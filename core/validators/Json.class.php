<?php defined('CORE') OR exit('No direct script access allowed');
class Json extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		if(!is_string($input) || '' === $input) {
			return false;
		}
		json_decode($input);
		return (json_last_error() === JSON_ERROR_NONE);
	}
}
