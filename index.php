<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('CORE', ROOT.DS.'core'.DS);
define('APP', ROOT.DS.'app'.DS);
define('VIEWS', APP.'views'.DS);
define('LAYOUTS', VIEWS.'layouts'.DS);

require_once CORE.'init.php';
