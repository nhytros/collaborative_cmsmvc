<?php
function html_escape($var, $double_encode = TRUE) {
	if (empty($var)) {
		return $var;
	}
	if (is_array($var)) {
		foreach (array_keys($var) as $key) {
			$var[$key] = html_escape($var[$key], $double_encode);
		}
		return $var;
	}
	return htmlspecialchars($var, ENT_QUOTES, Config::get('charset'), $double_encode);
}

function is_https() {
	if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
		return true;
	} elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
		return true;
	} elseif ( ! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
		return true;
	}
	return false;
}
