<?php defined('CORE') OR exit('No direct script access allowed');
class Required extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		return (!empty($input));
	}
}
