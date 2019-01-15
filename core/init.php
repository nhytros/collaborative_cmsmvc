<?php defined('CORE') OR exit('No direct script access allowed');
// session_set_cookie_params(1008000);
// ini_set('session.gc_maxlifetime', 1008000);
// ini_set('session.use_cookies', 1);
// ini_set('session.cookie_lifetime', 1008000);
/* set the cache expire to 30 minutes */
require_once APP.'config'.DS.'includes.php';

Session::init();
// Session::kill('lang');
// Session::set('lang','en');

	// Session::kill('lang');
	// Session::set('lang','en');
	// Config::set('lang',Session::get('lang'));
	// vd(Config::get('lang'));
	// vd(Session::get('lang'),1);
	// Session::set('lang',Config::get('lang'));


// Route the request
$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];

if(!Session::exists(Config::get('CurrentUserSessionName')) && Cookie::exists(Config::get('RememberMeCookieName'))) {
	Users::LoginUserFromCookie();
}

Router::route($url);
