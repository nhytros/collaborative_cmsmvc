<?php defined('CORE') OR exit('No direct script access allowed');
class Age extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		$date = date('U');
		$rule = $this->rule;
		return ;
	}
}
