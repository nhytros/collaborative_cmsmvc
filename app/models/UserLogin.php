<?php defined('CORE') OR exit('No direct script access allowed');
class UserLogin extends Model {
	public $username, $password, $remember;

	public function __construct() {
		parent::__construct('tmp_fake');
	}

	public function validator() {
		$this->runValidation(new Required($this,['field'=>'username','msg'=>'Devi inserire il nome utente']));
		$this->runValidation(new Required($this,['field'=>'password','msg'=>'Devi inserire la password']));
	}

	public function getRememberChecked() {
		return $this->remember == 'on';
	}
}
