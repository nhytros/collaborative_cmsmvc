<?php

function vd($dump, $die=false) {
	echo '<pre>';
	print_r($dump);
	echo '</pre>';
	if ($die) die();
}

function checkMessage() {
	if (isset($message)) {
		echo '
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<h4><?=$message; ?></h4>
			<button type="button" class="close" data-dismiss="alert" aria-label="Chiudi">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>';
	}
}

function getYear($year=2018) {
	if ($year < 2018) { return $year.'/'.date('Y'); }
	if ($year > 2018) { return date('Y'); }
	if (date('Y') > $year) { return $year.' / '.date('Y'); }
	return $year;
}

function getIcon($icon,$params=[]) {
	$iArray = explode(',',$icon);
	$type = $iArray[0];
	$icon = $iArray[1];
	if($params) {
		$p = '';
		foreach($params as $param) {
			$p .= ' '.$param;
		}
		$p = rtrim($p);
		$icon .= $p;
	}
	if($type=='fa') return '<i class="fa fa-fw fa-'.$icon.'"></i>';
	if($type=='bs') return '<span class="glyphicon glyphicon-'.$icon.'"></span>';
	if($type=='flag') return '<img src="/public/images/flags/'.$icon.'.png" />';
}


/**
* Truncate a float number, example: <code>truncate(-1.49999, 2); // returns -1.49
* truncate(.49999, 3); // returns 0.499
* </code>
* @param float $val Float number to be truncate
* @param int f Number of precision
* @return float
*/
function truncate($val,$f="0") {
    if(($p = strpos($val, '.')) !== false) {
        $val = floatval(substr($val, 0, $p + 1 + $f));
    }
    return $val;
}

//$delimiters has to be array
//$string has to be array

function multiexplode($delimiters,$string) {
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

function strsplit($string, $split_length=1) {
	$array = explode("\r\n", chunk_split($string, $split_length));
	array_pop($array);
	return $array;
}

function config($item) {
	return (Config::get($item) != '') ? Config::get($item) : null;
}

function getObjectProperties($obj) {
	return get_object_vars($obj);
}

function t($item) {
	if(file_exists(CORE.'lang'.DS.'main_'.Config::get('lang').'.php')) {
		require CORE.'lang'.DS.'main_'.Config::get('lang').'.php';
		return $lang[$item];
	} else {
		die('Language file not found');
	}
}
