<?php defined('CORE') OR exit('No direct script access allowed');
class LessThan extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		return ($input < $this->rule);
	}
}
