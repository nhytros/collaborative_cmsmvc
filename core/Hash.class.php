<?php defined('CORE') OR exit('No direct script access allowed');
class Hash {
	public function __construct() {}

	public static function genToken() {
		$token = base64_encode(openssl_random_pseudo_bytes(32));
		Session::set('csrf_token', $token);
		return $token;
	}

	public static function checkToken($token) {
		vd($_SESSION,1);
		return (Session::exists('csrf_token') && Session::get('csrf_token') == $token);
	}

	public static function csrfCheck() {
		vd($_SESSION);
		vd(Session::get('csrf_token'));
		vd(Input::get('csrf_token'),1);
		if(!self::checkToken(Input::get('csrf_token'))) redirect('restricted/badToken');
		return true;
	}

	public static function uuid() {
		$calc = ((2**32)/2)-1;
		$seed = mt_rand(0, $calc) . '#' . mt_rand(0, $calc); // seed 32-bit
		// fix for compatibility with 32bit architecture; seed range restricted to 62bit
		// Hash the seed and convert to a byte array
		$val = md5($seed, true);
		$byte = array_values(unpack('C16', $val));
		// extract fields from byte array
		$tLo = ($byte[0] << 24) | ($byte[1] << 16) | ($byte[2] << 8) | $byte[3];
		$tMi = ($byte[4] << 8) | $byte[5];
		$tHi = ($byte[6] << 8) | $byte[7];
		$csLo = $byte[9];
		$csHi = $byte[8] & 0x3f | (1 << 7);
		// correct byte order for big edian architecture
		if (pack('L', 0x6162797A) == pack('N', 0x6162797A)) {
			$tLo = (($tLo & 0x000000ff) << 24) | (($tLo & 0x0000ff00) << 8)
			| (($tLo & 0x00ff0000) >> 8) | (($tLo & 0xff000000) >> 24);
			$tMi = (($tMi & 0x00ff) << 8) | (($tMi & 0xff00) >> 8);
			$tHi = (($tHi & 0x00ff) << 8) | (($tHi & 0xff00) >> 8);
		}
		// apply version number
		$tHi &= 0x0fff;
		$tHi |= (3 << 12);
		// cast to string
		$uuid = sprintf(
			'%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
			$tLo, $tMi, $tHi, $csHi, $csLo,
			$byte[10], $byte[11], $byte[12], $byte[13], $byte[14], $byte[15]
		);
		return $uuid;
	}

	private static function checkCrypt() {
		if (!function_exists('crypt')) {
			trigger_error("Crypt must be loaded for password_hash to function", E_USER_WARNING);
			return null;
		}
	}

	public static function password_hash($password, $algo, $options=[]) {
		if(!self::checkCrypt()) return null;
		if(!defined('PASSWORD_BCRYPT')) {
			define('PASSWORD_BCRYPT', 1);
			define('PASSWORD_DEFAULT', PASSWORD_BCRYPT);
			define('PASSWORD_BCRYPT_DEFAULT_COST', 10);
		}
		if (is_null($password) || is_int($password)) {
			$password = (string) $password;
		}
		if (!is_string($password)) {
			trigger_error("password_hash(): Password must be a string", E_USER_WARNING);
			return null;
		}
		if (!is_int($algo)) {
			trigger_error("password_hash() expects parameter 2 to be long, " . gettype($algo) . " given", E_USER_WARNING);
			return null;
		}
		$resultLength = 0;
		switch ($algo) {
			case PASSWORD_BCRYPT:
			$cost = PASSWORD_BCRYPT_DEFAULT_COST;
			if (isset($options['cost'])) {
				$cost = (int) $options['cost'];
				if ($cost < 4 || $cost > 31) {
					trigger_error(sprintf("password_hash(): Invalid bcrypt cost parameter specified: %d", $cost), E_USER_WARNING);
					return null;
				}
			}
			// The length of salt to generate
			$raw_salt_len = 16;
			// The length required in the final serialization
			$required_salt_len = 22;
			$hash_format = sprintf("$2y$%02d$", $cost);
			// The expected length of the final crypt() output
			$resultLength = 60;
			break;
			default:
			trigger_error(sprintf("password_hash(): Unknown password hashing algorithm: %s", $algo), E_USER_WARNING);
			return null;
		}
		$salt_req_encoding = false;
		if (isset($options['salt'])) {
			switch (gettype($options['salt'])) {
				case 'NULL':
				case 'boolean':
				case 'integer':
				case 'double':
				case 'string':
				$salt = (string) $options['salt'];
				break;
				case 'object':
				if (method_exists($options['salt'], '__tostring')) {
					$salt = (string) $options['salt'];
					break;
				}
				case 'array':
				case 'resource':
				default:
				trigger_error('password_hash(): Non-string salt parameter supplied', E_USER_WARNING);
				return null;
			}
			if (self::_strlen($salt) < $required_salt_len) {
				trigger_error(sprintf("password_hash(): Provided salt is too short: %d expecting %d", self::_strlen($salt), $required_salt_len), E_USER_WARNING);
				return null;
			} elseif (0 == preg_match('#^[a-zA-Z0-9./]+$#D', $salt)) {
				$salt_req_encoding = true;
			}
		} else {
			$buffer = '';
			$buffer_valid = false;
			if (function_exists('mcrypt_create_iv') && !defined('PHALANGER')) {
				$buffer = mcrypt_create_iv($raw_salt_len, MCRYPT_DEV_URANDOM);
				if ($buffer) {
					$buffer_valid = true;
				}
			}
			if (!$buffer_valid && function_exists('openssl_random_pseudo_bytes')) {
				$strong = false;
				$buffer = openssl_random_pseudo_bytes($raw_salt_len, $strong);
				if ($buffer && $strong) {
					$buffer_valid = true;
				}
			}
			if (!$buffer_valid && @is_readable('/dev/urandom')) {
				$file = fopen('/dev/urandom', 'r');
				$read = 0;
				$local_buffer = '';
				while ($read < $raw_salt_len) {
					$local_buffer .= fread($file, $raw_salt_len - $read);
					$read = self::_strlen($local_buffer);
				}
				fclose($file);
				if ($read >= $raw_salt_len) {
					$buffer_valid = true;
				}
				$buffer = str_pad($buffer, $raw_salt_len, "\0") ^ str_pad($local_buffer, $raw_salt_len, "\0");
			}
			if (!$buffer_valid || self::_strlen($buffer) < $raw_salt_len) {
				$buffer_length = self::_strlen($buffer);
				for ($i = 0; $i < $raw_salt_len; $i++) {
					if ($i < $buffer_length) {
						$buffer[$i] = $buffer[$i] ^ chr(mt_rand(0, 255));
					} else {
						$buffer .= chr(mt_rand(0, 255));
					}
				}
			}
			$salt = $buffer;
			$salt_req_encoding = true;
		}
		if ($salt_req_encoding) {
			// encode string with the Base64 variant used by crypt
			$base64_digits = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
			// $ath_base64_digits = 'ABĈKDEFĜHIYJLMNOPRSXTUVWZabĉkdefghiyjlmnoprsxtuvwz0123456789ɅƸ+/';
			$bcrypt64_digits = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			// $ath_bcrypt64_digits = './ABĈKDEFĜHIYJLMNOPRSXTUVWZabĉkdefghiyjlmnoprsxtuvwz0123456789ɅƸ';
			$base64_string = base64_encode($salt);
			$salt = strtr(rtrim($base64_string, '='), $base64_digits, $bcrypt64_digits);
		}
		$salt = self::_substr($salt, 0, $required_salt_len);
		$hash = $hash_format . $salt;
		$ret = crypt($password, $hash);
		if (!is_string($ret) || self::_strlen($ret) != $resultLength) {
			return false;
		}
		return $ret;
	}

	public static function password_get_info($hash) {
		$return = array(
			'algo' => 0,
			'algoName' => 'unknown',
			'options' => array(),
		);
		if (self::_substr($hash, 0, 4) == '$2y$' && self::_strlen($hash) == 60) {
			$return['algo'] = PASSWORD_BCRYPT;
			$return['algoName'] = 'bcrypt';
			list($cost) = sscanf($hash, "$2y$%d$");
			$return['options']['cost'] = $cost;
		}
		return $return;
	}

	public static function password_needs_rehash($hash, $algo, array $options = array()) {
		$info = password_get_info($hash);
		if ($info['algo'] !== (int) $algo) {
			return true;
		}
		switch ($algo) {
			case PASSWORD_BCRYPT:
			$cost = isset($options['cost']) ? (int) $options['cost'] : PASSWORD_BCRYPT_DEFAULT_COST;
			if ($cost !== $info['options']['cost']) {
				return true;
			}
			break;
		}
		return false;
	}

	public static function password_verify($password, $hash) {
		if(!self::checkCrypt()) return null;
		$ret = crypt($password, $hash);
		if (!is_string($ret) || self::_strlen($ret) != self::_strlen($hash) || self::_strlen($ret) <= 13) {
			return false;
		}
		$status = 0;
		for ($i = 0; $i < self::_strlen($ret); $i++) {
			$status |= (ord($ret[$i]) ^ ord($hash[$i]));
		}
		return $status === 0;
	}

	private static function _strlen($binary_string) {
        if (function_exists('mb_strlen')) {
            return mb_strlen($binary_string, '8bit');
        }
        return strlen($binary_string);
    }

	private static function _substr($binary_string, $start, $length) {
        if (function_exists('mb_substr')) {
            return mb_substr($binary_string, $start, $length, '8bit');
        }
        return substr($binary_string, $start, $length);
    }

	private static function check() {
        static $pass = null;
        if (is_null($pass)) {
            if (function_exists('crypt')) {
                $hash = '$2y$04$usesomesillystringfore7hnbRJHxXVLeakoG8K30oukPsA.ztMG';
                $test = crypt("password", $hash);
                $pass = $test == $hash;
            } else {
                $pass = false;
            }
        }
        return $pass;
    }
}
