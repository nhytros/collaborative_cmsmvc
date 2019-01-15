<?php defined('CORE') OR exit('No direct script access allowed');
class UserRegister extends Model {
	public $id, $username, $email, $password, $birth_date,
	$first_name, $last_name, $display_name, $bio=null, $profile_image, $_confirm=false,
	$acl, $last_login=null, $created_at, $status=1, $role=2, $deleted=0;

	public function __construct() {
		parent::__construct('tmp_fake');
	}

	public function validator() {
		// Validate First and Last name
		$this->runValidation(new Required($this,['field'=>'first_name','msg'=>'The first name is required.']));
		$this->runValidation(new Required($this,['field'=>'last_name','msg'=>'The last name is required.']));

		// Validate username
		$this->runValidation(new Required($this,['field'=>'username','msg'=>'The username is required.']));
		$this->runValidation(new MinLength($this,['field'=>'username','rule'=>3,'msg'=>'The username must be at least 3 characters.']));
		$this->runValidation(new MaxLength($this,['field'=>'username','rule'=>30,'msg'=>'The username cannot be over 30 characters.']));
		$this->runValidation(new Unique($this,['field'=>'username','msg'=>'This username is already taken.']));

		// Validate email
		$this->runValidation(new Required($this,['field'=>'email','msg'=>'The E-mail address is required.']));
		$this->runValidation(new Email($this,['field'=>'email','msg'=>'You must provide a valid E-mail address.']));
		$this->runValidation(new Unique($this,['field'=>'email','msg'=>'This E-mail address is already registered.']));

		// Validate password
		$this->runValidation(new Required($this,['field'=>'password','msg'=>'The password is required.']));
		$this->runValidation(new MinLength($this,['field'=>'password','rule'=>8,'msg'=>'The password must be at least 8 characters.']));
		$this->runValidation(new Match($this,['field'=>'password',$this->_confirm,'msg'=>'Your passwords do not match.']));
	}

	public function setConfirm($value) {
		$this->_confirm = $value;
	}

	public function getConfirm() {
		return $this->_confirm;
	}

	public function getFullName($name) {
		vd(name,1);
		$first_name = $name[0];
		$last_name = $name[1];
	}

	public function beforeSave() {
		$this->created_at = date('U');
		$this->password = password_hash($this->password, PASSWORD_DEFAULT);
	}

	public function afterSave() {}


}
