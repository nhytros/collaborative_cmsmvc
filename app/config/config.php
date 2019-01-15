<?php defined('CORE') OR exit('No direct script access allowed');

// Site mode - Values are: development, production
Config::set('mode', 'development');

// General Site Settings
Config::set('site_url', 'http://localhost');
Config::set('site_name', 'Site Name');
Config::set('charset', 'utf-8');
Config::set('dir', 'ltr');

// Language UI Settings
if(!Session::exists('lang')) {
	Session::set('lang','en');
	Config::set('lang','en');
} else {
	Config::set('lang', Session::get('lang'));
}

// Page Settings
Config::set('breadcrumb', false);
Config::set('default_controller', 'Home');
Config::set('default_layout', 'default');
Config::set('default_page_name', 'Default page name');
Config::set('default_error_page', 'Error');

// Time Settings
Config::set('one_day',            86400); // One day in seconds
Config::set('one_week',          604800); // One week in seconds (7 days)
Config::set('one_month',        2592000); // One month in seconds (30 days)
Config::set('six_months',      15552000); // Six months in seconds (180 days)
Config::set('one_year',        31536000); // One year in seconds (365 days)

// Database settings
Config::set('dbengn', 'mysql');
Config::set('dbhost', '127.0.0.1');
Config::set('dbuser', 'user');
Config::set('dbpass', 'password');
Config::set('dbname', 'database');
Config::set('dbport', '3306');
Config::set('dbpfix', '');
Config::set('dbcset', 'utf8');
Config::set('dbcoll', 'utf_unicode_ci');

// Session Settings
Config::set('csrf_protection', false);
Config::set('CurrentUserSessionName', md5(Config::get('site_name')));
Config::set('RememberMeCookieName', md5(Config::get('CurrentUserSessionName')));

// Stripe Settings
// Config::set('stripe_pk_test', 'pk_test_');
// Config::set('stripe_sk_test', 'sk_test_');
