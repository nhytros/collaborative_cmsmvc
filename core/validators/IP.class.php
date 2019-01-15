<?php defined('CORE') OR exit('No direct script access allowed');
class IP extends Validator {
	public function runValidation() {
		$input = $this->_model->{$this->field};
		if ($this->rule == '4' || strtolower($this->rule) == 'ipv4') {
			return (filter_var($input,FILTER_VALIDATE_IP, FILTER_FLAG_IPV4));
		} elseif ($this->rule == '6' || strtolower($this->rule) == 'ipv6') {
			return (filter_var($input,FILTER_VALIDATE_IP, FILTER_FLAG_IPV6));
		} else {
			return (filter_var($input,FILTER_VALIDATE_IP));
		}
	}
}
