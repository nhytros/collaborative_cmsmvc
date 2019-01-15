<?php defined('CORE') OR exit('No direct script access allowed');
class Users extends Model {
	private $_isLoggedIn, $_sessionName, $_cookieName, $_confirm;
	public $id, $username, $email, $password, $birth_date,
	$first_name, $last_name, $display_name, $bio=null, $profile_image,
	$acl, $last_login=null, $created_at, $status=1, $role=2, $deleted=0;
	public static $currentLoggedInUser = null;

	public function __construct($user='') {
		$table = 'users';
		parent::__construct($table);
		$this->_sessionName = config('CurrentUserSessionName');
		$this->_cookieName  = config('RememberMeCookieName');
		$this->status = 1;
		$field = (is_int($user)) ? 'id' : 'username';
		$u = $this->_db->findFirst($table,['conditions'=>$field.' = ?','bind'=>[$user]],'Users');
		if ($u) {
			foreach($u as $key => $val) {
				$this->$key = $val;
			}
		}
	}

	public function findByUsername($username) {
		return $this->findFirst(['conditions'=>'username = ?','bind'=>[$username]]);
	}

	public function findUsers($limit) {
		return $this->find(['conditions'=>'id != ? AND id != 1','bind'=>[self::currentUser()->id],['limit'=>$limit]]);
	}

	public static function getUsers($limit) {
		return self::find(['conditions'=>'id > ?','bind'=>['0'],['limit'=>$limit]]);
	}

	public static function following($uid) {
		$f = $this->_db->find('follow',['conditions'=>'user_one = ?','bind'=>[self::currentUser()->id]]);
		if ($f) {
			foreach($f as $fkey => $fval) {
				$this->fkey = $fval;
			}
		}
	}

	public static function currentUser() {
		if(!isset(self::$currentLoggedInUser) && Session::exists(config('CurrentUserSessionName'))) {
			$u = new Users((int)Session::get(config('CurrentUserSessionName')));
			self::$currentLoggedInUser = $u;
		}
		return self::$currentLoggedInUser;
	}

	public static function displayName() {
		return self::currentUser()->first_name.' '.self::currentUser()->last_name;
	}


	public function login($rememberMe = false) {
		Session::set($this->_sessionName, $this->id);
		if ($rememberMe) {
			$hash = md5(uniqid().time().rand(0,100));
			$user_agent = Session::uagentNoVersion();
			Cookie::set($this->_cookieName, $hash, Config::get('one_year'));
			$fields = [
				'uid'        => $this->id,
				'session'    => $hash,
				'user_agent' => $user_agent,
			];
			$this->_db->query('DELETE FROM user_sessions WHERE uid = ? AND user_agent = ?',[$this->id, $user_agent]);
			$this->_db->insert('user_sessions', $fields);
		}
	}

	public static function LoginUserFromCookie() {
		$userSession = UserSessions::getFromCookie();
		$user = new self((int)$userSession->id);
		if($userSession->id != '') {
			$user = new self((int)$userSession->id);
		}
		if($user) {
			$user->login();
		}
		return $user;
	}

	public function logout() {
		$userSession = UserSessions::getFromCookie();
		if($userSession) $userSession->delete();
		Session::kill(config('CurrentUserSessionName'));
		if(Cookie::exists(config('RememberMeCookieName'))) {
			Cookie::delete(config('RememberMeCookieName'));
		}
		if(Session::exists('lang')) { Session::kill('lang'); }
		self::$currentLoggedInUser = null;
		return true;
	}

	public function acls() {
		if (empty($this->acl)) return [];
		// return json_decode($this->acls, true);
		return $this->acl;
	}
}
