<?php defined('CORE') OR exit('No direct script access allowed');
class Bank {

}


class CC extends Bank {

	/**
	* Generates the random credit card number using the given prefix and
	* length. It uses default otherwise
	* @param integer $prefix
	* @param integer $length
	* @return string
	*/
	public static function single($prefix = null, $length = 16) {
		if ($length <= strlen($prefix)) {
			die(
				'The \'length\' parameter should be greater than \'prefix\' '.
				'string length'
			);
		}
		$number = $prefix . self::getRand($length - strlen($prefix));
		return $number . self::verificationDigit($number);
	}

	/**
	* Generates the given amount of credit card numbers
	* @param integer $amount
	* @param integer $prefix
	* @param integer $length
	* @return integer[]
	*/
	public static function lot($amount, $prefix = null, $length = 16) {
		$numbers = [];
		for ($index = 1; $index <= $amount; $index++) {
			$numbers[] = self::single($prefix, $length);
		}
		return $numbers;
	}

	/**
	* Retrieves a random number to put in the middle of card number
	* Example: length = 5: Generates a number between 00000 and 99999
	* @param integer $length
	* @return integer
	*/
	public static function getRand($length) {
		$rand = '';
		for ($index = 1; $index < $length; $index++) {
			$rand .= rand(0, 9);
		}
		return $rand;
	}

	/**
	* Executes Luhn algorithm over the given number and return the sum. This
	* method does not include last digit of credit card number (verification
	* digit).
	* @param string|integer $number
	* @return integer
	*/
	private static function sum($number) {
		$numberArray = array_reverse(str_split($number));
		$sum = 0;
		for ($index = 0; $index < count($numberArray); $index++) {
			$digit = (int)$numberArray[$index];
			$sum += ($index % 2 == 0) ? self::multiplyNumber($digit) : $digit;
		}
		return $sum;
	}

	/**
	* Retrives the corresponding verfication digit of the given credit card
	* number. If the verification digit is ten, returns zero
	* @param string|integer $number
	* @return integer
	*/
	private static function verificationDigit($number) {
		return 10 - (self::sum($number) % 10 ?: 10);
	}

	/**
	* Multiplies number by two and decrease 9 if the number is greater than 10
	* @param integer $number
	* @return integer
	*/
	private static function multiplyNumber($number) {
		$result = $number * 2;
		return ($result >= 10) ? $result - 9 : $result;
	}

	/**
	* Validates the given number using Luhn algorithm
	* @param  string|integer $number
	* @return boolean
	*/
	public static function isValid($number) {
		$lastDigit = substr($number, -1);
		$number    = substr($number, 0, -1);
		return (self::verificationDigit($number)) == $lastDigit;
	}
}
