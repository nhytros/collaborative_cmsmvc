<?php
function site_url($uri='') {
	return Config::get('site_url').DS.$uri;
}

// function base_url($uri='') {
// 	return Config::get('site_url').DS.$uri;
// }

// function anchor($uri = '', $title = '', $attributes = '') {
// 	$title = (string) $title;
// 	$site_url = is_array($uri)
// 		? site_url($uri)
// 		: (preg_match('#^(\w+:)?//#i', $uri) ? $uri : site_url($uri));
// 	if ($title === '') { $title = $site_url; }
// 	if ($attributes !== '') { $attributes = _stringify_attributes($attributes); }
// 	return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
// }

function redirect($url='') { Router::redirect($url); }

function currentPage() {
	$currentPage = $_SERVER['REQUEST_URI'];
	if($currentPage == base_url() || $currentPage == base_url('home/index')) {
		$currentPage = base_url('home');
	}
	return $currentPage;
}

function base_url($uri = '', $protocol = NULL) {
	$base_url = slash_item('site_url');
	if (isset($protocol)) {
		// For protocol-relative links
		$base_url = ($protocol === '')
		? substr($base_url, strpos($base_url, '//'))
		: $protocol.substr($base_url, strpos($base_url, '://'));
	}
	return $base_url._uri_string($uri);
}

function _uri_string($uri) {
	if (config('enable_query_strings') === FALSE) {
		is_array($uri) && $uri = implode('/', $uri);
		return ltrim($uri, '/');
	} elseif (is_array($uri)) {
		return http_build_query($uri);
	}
	return $uri;
}

function slash_item($item) {
	$siteurl = config($item);
	if (!isset($siteurl)) { return NULL;
	} elseif (trim($siteurl) === '') { return ''; }
	return rtrim($siteurl, '/').'/';
}

function active_anchor($controller,$path,$title,$icon="", $extra=[]) {
	if ($icon) {
		$i = '<i class="fa fa-'.$icon.'" aria-hidden="true"></i>&nbsp;';
		$title = $i.$title;
	}
	switch ($controller) {
		case 'dropdown':
		return '<li class="dropdown'.activate_menu($controller).'">'.anchor($path, $title.'&nbsp;<span class="caret"></span>', $extra);
		break;
		case 'button':
		// return anchor($path, $title, $extra);
		break;
		default:
		return '<li class="'.activate_menu($controller).'">'.anchor($path, $title, $extra).'</li>';
		break;
	}
}

function activate_menu($controller) {
	if ($controller == 'dropdown') $controller = '';
	// Getting CI class instance.
	// Getting router class to active.
	return ($controller) ? 'active' : '';
}

function checkPage($controller) {
	return ($class == $controller);
}

function anchor($path, $title='', $extra=[]) {
	$ex = '';
	foreach($extra as $x) {
		$ex = $x.' ';
	}
	$ex = rtrim($ex,' ');
	return '<a href="'.$path.' '.$ex.'">'.$title.'</a>';
}

function breadcrumb($controller, $path, $title, $icon, $extra=[]) {
	return active_anchor($controller,$path,$title,$icon,$extra).'&nbsp;/&nbsp;';
}
