<?php defined('CORE') OR exit('No direct script access allowed');
class IsInfinite extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		return (is_numeric($input) && is_infinite($input));
	}
}
