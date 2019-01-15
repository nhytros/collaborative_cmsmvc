<?php defined('CORE') OR exit('No direct script access allowed');
class UserSessions extends Model {
	public $uid, $session, $user_agent;
	
	public function __construct() {
		$table = 'user_sessions';
		parent::__construct($table);
	}

	public static function getFromCookie() {
		$userSession = new self();
		if(Cookie::exists(config('RememberMeCookieName'))) {
			$userSession = $userSession->findFirst([
				'conditions' => 'user_agent = ? AND session = ?',
				'bind'		 => [Session::uagentNoVersion(),Cookie::get(config('RememberMeCookieName'))]
			]);
		}
		if(!$userSession) return false;
		return $userSession;
	}
}
