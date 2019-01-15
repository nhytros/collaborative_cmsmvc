<?php defined('CORE') OR exit('No direct script access allowed');
class AlwaysValid extends Validator {
	public function runValidation() {
		return true;
	}
}
