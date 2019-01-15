<?php defined('CORE') OR exit('No direct script access allowed');
class IsEven extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		return ((int) $input % 2 === 0);
	}
}
