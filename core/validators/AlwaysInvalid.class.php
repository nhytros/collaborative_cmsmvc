<?php defined('CORE') OR exit('No direct script access allowed');
class AlwaysInvalid extends Validator {
	public function runValidation() {
		return false;
	}
}
