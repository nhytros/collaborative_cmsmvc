<?php defined('CORE') OR exit('No direct script access allowed');
class Slug extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		if (strstr($input, '--')) { return false; }
		if (!preg_match('@^[0-9a-z\-]+$@',$input)) { return false; }
		if (preg_match('@^-|-$@', $input)) { return false; }
		return true;
	}
}
