<?php defined('CORE') OR exit('No direct script access allowed');

class Router {
	public static function route($url) {
		// Controller
		$controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]).'Controller' : config('default_controller').'Controller';
		$controller_name = str_replace('Controller','',$controller);
		array_shift($url);

		// Action
		$action = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]) : 'index';
		$action_name = (isset($url[0]) && $url[0] != '') ? $url[0] : 'index';
		array_shift($url);

		// ACL Check
		$grantAccess = self::hasAccess($controller_name, $action_name);
		if (!$grantAccess) {
			$controller = config('AccessRestricted').'Controller';
			$controller_name = config('AccessRestricted');
			$action = 'index';
		}

		// Params
		$queryParams = $url;
		$dispatch = new $controller($controller_name, $action);
		if (method_exists($controller, $action)) {
			call_user_func_array([$dispatch, $action], $queryParams);
		} else {
			die('The method <em>"'.$action.'"</em> does not exists in controller <b>'.$controller.'</b>');
		}
	}

	public static function redirect($location) {
		if($location == 'prev' && isset($_SERVER['HTTP_REFERER'])) {
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit;
		}
		if (!headers_sent()) {
			header('Location: '.base_url($location));exit;
		} else {
			echo '<script type="text/javascript">window.location.href="'.siteUrl($location).'";</script>'."\n";
			echo '<noscript><meta http-equiv="refresh" content="0;url='.siteUrl($location).'" /></noscript>';
			exit;
		}
	}

	public static function hasAccess($controller_name, $action_name='index') {
		$acl_file = file_get_contents(APP.'config'.DS.'acl.json');
		$acl = json_decode($acl_file, true);
		$current_user_acls = ["Guest"];
		$grantAccess = false;
		if (Session::exists(config('CurrentUserSessionName'))) {
			$current_user_acls = ['LoggedIn'];
			foreach(Users::currentUser()->acls() as $a) {
				$current_user_acls[] = $a;
			}
		}
		foreach($current_user_acls as $level) {
			if (array_key_exists($level, $acl) && array_key_exists($controller_name, $acl[$level])) {
				if(in_array($action_name, $acl[$level][$controller_name]) || in_array("*", $acl[$level][$controller_name])) {
					$grantAccess = true;
					break;
				}
			}
		}

		// Check for denied
		foreach($current_user_acls as $level) {
			$denied = $acl[$level]['denied'];
			if(!empty($denied) && array_key_exists($controller_name, $denied) && in_array($action_name, $denied[$controller_name])) {
				$grantAccess = false;
				break;
			}
		}
		return $grantAccess;
	}

	public static function getMenu($menu) {
		$menuArray = [];
		$menuFile = file_get_contents(CORE.'lang'.DS.$menu.'_'.Config::get('lang').'.json');
		$acl = json_decode($menuFile, true);
		foreach($acl as $key => $val) {
			if(is_array($val)) {
				$sub = [];
				// $link = $val[0];
				// $icon = $val[1];
				foreach($val as $k => $v) {
					if($k == 'separator' && !empty($sub)) {
						$sub[$k] = '';
						continue;
					} else if($finalVal = self::get_link($v)) {
						// $finalIcon = get_icon($icon);
						$sub[$k] = $finalVal;
					}
				}
				if(!empty($sub)) {
					$menuArray[$key] = $sub;
				}
			} else {
				if($finalVal = self::get_link($val)) {
					// $finalIcon = get_icon($icon);
					$menuArray[$key] = $finalVal;
				}
			}
		}
		return $menuArray;
	}

	public static function getIcon($menu) {
		$menuArray = [];
		$menuFile = file_get_contents(APP.'config'.DS.$menu.'.json');
		$acl = json_decode($menuFile, true);
		foreach($acl as $key => $val) {
			if(is_array($val)) {
				$sub = [];
				$icon = $val[1];
				$i = explode(',',$icon);
				foreach($i as $k => $v) {
					if ($v[0] == 'fa') $finalIcon = '<i class="fa fa-'.$v[1].'"></i>';
					if ($v[0] == 'bs') $finalIcon = '<span class="glyphicon glyphicon-'.$v[1].'"></span>';
				}
				foreach($val as $k => $v) {
					if($k == 'separator' && !empty($sub)) {
						$sub[$k] = '';
						continue;
					} else if($finalVal = self::get_link($v)) {
						$sub[$k] = $finalVal;
					}
				}
				if(!empty($sub)) {
					$menuArray[$key] = $sub;
				}
			} else {
				if($finalVal = self::get_link($val)) {
					$menuArray[$key] = $finalVal;
				}
			}
		}
		return $menuArray;

	}

	private static function get_link($val) {
		// Check if external link
		if(preg_match('/https?:\/\//', $val) == 1) {
			return $val;
		} else {
			$uArray = explode('/', $val);
			$controller_name = ucwords($uArray[0]);
			$action_name = (isset($uArray[1])) ? $uArray[1] : '';
			if(self::hasAccess($controller_name, $action_name)) {
				return $val;
			}
			return false;
		}
	}
}
