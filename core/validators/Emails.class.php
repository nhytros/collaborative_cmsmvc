<?php defined('CORE') OR exit('No direct script access allowed');
class Emails extends Validator {
	// To Check
	public function runValidation() {

		foreach ($this->_model->{$this->field} as $email) {
		    echo (filter_var($email, FILTER_VALIDATE_EMAIL)) ?
		        "[+] Email '$email' is valid\n" :
		        "[-] Email '$email' is NOT valid\n";
		}


		return (filter_var($this->_model->{$this->field}, FILTER_VALIDATE_EMAIL));
	}
}
