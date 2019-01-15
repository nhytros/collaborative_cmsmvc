<?php defined('CORE') OR exit('No direct script access allowed');
class MinimumAge extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		$minage = $this->rule;
		$minage_sec = $minage * 31557600;
		$now = time();
		$diff = $now - $minage_sec;
		
	}
}
