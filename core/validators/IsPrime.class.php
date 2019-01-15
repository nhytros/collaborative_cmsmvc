<?php defined('CORE') OR exit('No direct script access allowed');
class IsPrime extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		if (!is_numeric($input) || $input <= 1) { return false; }
        if ($input != 2 && ($input % 2) ==  0) { return false; }
        for ($i = 3; $i <= ceil(sqrt($input)); $i += 2) {
            if (($input % $i) == 0) { return false; }
        }
        return true;
	}
}
