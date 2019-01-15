<?php defined('CORE') OR exit('No direct script access allowed');
class Lowercase extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		return $input === mb_strtolower($input, mb_detect_encoding($input));
	}
}
