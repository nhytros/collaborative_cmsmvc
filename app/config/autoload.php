<?php defined('CORE') OR exit('No direct script access allowed');

$autoload['helpers'] = ['mwd','url','common'];

// Autoload Classes
function autoload($class) {
	if(strtolower($class) == 'cc') $class = 'Bank';
	if(file_exists(CORE.$class.'.class.php')) {
		require_once CORE.$class.'.class.php';
	} elseif(file_exists(APP.'controllers'.DS.$class.'.php')) {
		require_once APP.'controllers'.DS.$class.'.php';
	} elseif(file_exists(APP.'models'.DS.$class.'.php')) {
		require_once APP.'models'.DS.$class.'.php';
	} elseif(file_exists(CORE.'validators'.DS.$class.'.class.php')) {
		require_once CORE.'validators'.DS.$class.'.class.php';
	} elseif(file_exists(APP.'custom/validators'.DS.$class.'.class.php')) {
		require_once APP.'custom/validators'.DS.$class.'.class.php';
	}
}
spl_autoload_register('autoload');

//Autoload Helpers
foreach($autoload as $a => $val) {
	switch(strtolower($a)) {
		case 'helpers':
		foreach($val as $file)
		if (file_exists(CORE.$a.DS.$file.'.php')) {
			require_once CORE.$a.DS.$file.'.php';
		} elseif (file_exists(APP.'custom'.DS.$a.DS.$file.'.php')) {
			require_once APP.'custom'.DS.$a.DS.$file.'.php';
		}
		default: break;
	}
}

//require_once APP.'vendor'.DS.'autoload.php';
