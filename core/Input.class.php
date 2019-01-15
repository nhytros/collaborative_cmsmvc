<?php defined('CORE') OR exit('No direct script access allowed');
class Input {
	public static function sanitize($var, $double_encode = TRUE) {
	  if (empty($var)) return $var;
	  if (is_array($var)) {
	    foreach (array_keys($var) as $key) {
	      $var[$key] = self::sanitize($var[$key], $double_encode);
	    }
	    return $var;
	  }
	  return htmlentities($var, ENT_QUOTES, Config::get('charset'), $double_encode);
	}

	public function exists($type='post') {
		switch (strtolower($type)) {
			case 'post': return (!empty($_POST)) ? true : false; break;
			case 'get': return (!empty($_GET)) ? true : false; break;
		}
	}

	public function isPost() {
		return $this->getRequestMethod() === 'POST';
	}

	public function isPut() {
		return $this->getRequestMethod() === 'PUT';
	}

	public function isGet() {
		return $this->getRequestMethod() === 'GET';
	}

	public function getRequestMethod() {
		return strtoupper($_SERVER['REQUEST_METHOD']);
	}

	public static function get($input=false) {
		if(!$input) {
			$data = [];
			foreach($_REQUEST as $field => $value) {
				$data[$field] = self::sanitize($value);
			}
			return $data;
		}
		return self::sanitize($_REQUEST[$input]);
	}

	public static function hashtag($text) {
		$regex = "/#+([a-zA-Z0-9_ĉĈĝĜɅƸđꜲ]+)/";
		$str = preg_replace($regex, '<a href="hashtag.php?tag=$1">$0</a>', $text);
		return $str;
	}

	public static function usertag($text) {
		$regex = "/@+([a-zA-Z0-9_ĉĈĝĜɅƸđꜲ]+)/";
		$str = preg_replace($regex, '<a href="usertag.php?tag=$1">$0</a>', $text);
		return $str;
	}

	public static function timestamp($given_time) {
		$current_time = time();
		if($current_time >= $given_time) {
			$diff_time = $current_time - $given_time;
			$seconds = $diff_time;
			$minutes = round($diff_time / 60);
			$hours = round($diff_time / 3600);
			$days = round($diff_time / 86400);
			$weeks = round($diff_time / 604800);
			$months = round($diff_time / 2629800);
			$years = round($diff_time / 31557600);

			if($seconds <= 30) {
				$ret = 'poco fa';
			} elseif($seconds > 30 && $seconds <= 60) {
				$ret = $seconds.' secondi fa';
			} elseif($minutes <= 60) {
				$ret = ($minutes == 1) ? ' minuto fa' : ' minuti fa';
				$ret = $minutes.$ret;
			} elseif($hours <= 24) {
				$ret = ($hours == 1) ? ' ora fa' : ' ore fa';
				$ret = $hours.$ret;
			} elseif($days <= 7) {
				$ret = ($days == 1) ? ' giorno fa' : ' giorni fa';
				$ret = $days.$ret;
			} elseif($weeks <= 4) {
				$ret = ($weeks == 1) ? ' settimana fa' : ' settimane fa';
				$ret = $weeks.$ret;
			} elseif($months <= 12) {
				$ret = ($months == 1) ? ' mese fa' : ' mesi fa';
				$ret = $months.$ret;
			} else {
				$ret = ($years == 1) ? ' anno fa' : ' anni fa';
				$ret = $years.$ret;
			}
			return $ret;
		} else {
			die('Given timestamp value is greater than current timestamp value');
		}
	}

}
