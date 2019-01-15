<?php defined('CORE') OR exit('No direct script access allowed');
class Validate {
	private $_passed = false,
	$_errors = [],
	$_db = null;

	public function __construct() {
		$this->_db = DB::getInstance();
	}

	public function check($source, $items=[],$csrfCheck=false) {
		$this->_errors = [];
		if($csrfCheck) {
			$csrfPass = Hash::checkToken($source['csrf_token']);
			if(!isset($source['csrf_token']) && !$csrfPass) {
				$this->addError(['Si è verificato un errore CSRF. Si prega di ricaricare la pagina','csrf_token']);
			}
		}
		foreach($items as $item => $rules) {
			$item = Input::sanitize($item);
			$display = $rules['display'];
			foreach ($rules as $rule => $rule_value) {
				$value = Input::sanitize(trim($source[$item]));
				if(empty($value) && $rule == 'required' && $rule_value = true) {
					$this->addError(["Non hai inserito {$display}", $item]);
				} else {
					switch($rule) {
						case 'match':
						if($value != $source[$rule_value]) {
							$matchDisplay = $items[$rule_value]['display'];
							$this->addError(["{$matchDisplay} e {$display} devono corrispondere", $item]);
						}
						break;
						case 'regex_match': break; /* TDB */
						case 'differs': break; /* TDB */
						case 'unique':
						$check = $this->_db->query("SELECT {$item} FROM {$rule_value} WHERE {$item} = ?",[$value]);
						if($check->count()) {
							$this->addError(["{$display} è già registrato", $item]);
						}
						break;
						case 'unique_update':
						$t = explode(',',$rule_value);
						$table = $t[0];
						$id_fieldname = $t[1];
						$id = $t[2];
						$query = $this->_db->query("SELECT * FROM {$table} WHERE {$id_fieldname} != ? AND {$item} = ?", [$id,$value]);
						if($query->count()) $this->addError(["{$display} è già registrato", $item]);break;
						case 'min_length':if(strlen($value) < $rule_value) $this->addError(["{$display} deve contenere almeno {$rule_value} caratteri", $item]);break;
						case 'max_length':if(strlen($value) > $rule_value) $this->addError(["{$display} deve contenere al massimo {$rule_value} caratteri", $item]);break;
						case 'exact_length':if(strlen($value) != $rule_value) $this->addError(["{$display} deve contenere {$rule_value} caratteri", $item]);break;
						case 'differs': break;/* TDB */
						case 'greater_than_equal_to': break;/* TDB */
						case 'less_than': break;/* TDB */
						case 'less_than_equal_to': break;/* TDB */
						case 'in_list': break;/* TDB */
						case 'alpha':if(!ctype_alpha(filter_var($value, FILTER_SANITIZE_STRING))) $this->addError(["{$display} deve contenere solamente lettere (a-z/A-Z)", $item]);break;
						case 'alpha_numeric':if(!ctype_alnum(filter_var($value, FILTER_SANITIZE_STRING))) $this->addError(["{$display} deve essere un valore alfanumerico (a-z/A-Z/0-9)", $item]);break;
						case 'alpha_numeric_spaces': break;/* TDB */
						case 'alpha_dash': break;/* TDB */
						case 'numeric':if(!ctype_digit(filter_var($value, FILTER_SANITIZE_NUMBER_INT))) $this->addError(["{$display} deve essere un valore numerico (0-9)", $item]);break;
						case 'min':if($value < $rule_value) $this->addError(["{$display} deve essere uguale o superiore a {$rule_value}", $item]);
						case 'max':if($value > $rule_value) $this->addError(["{$display} deve essere uguale o inferiore a {$rule_value}", $item]);
						case 'exact':if($value != $rule_value) $this->addError(["{$display} deve essere uguale a {$rule_value}", $item]);
						case 'integer': break;/* TDB */
						case 'decimal': break;/* TDB */
						case 'is_natural': break;/* TDB */
						case 'is_natural_no_zero': break;/* TDB */
						case 'url': break;/* TDB */
						case 'email':if(!filter_var($value, FILTER_SANITIZE_EMAIL)) $this->addError(["Hai inserito un {$display} non valido", $item]);break;
						case 'emails':
						$emails = str_replace(' ', '', $emails);
						$emails = explode(',',$value);
						foreach($emails as $email) {
							if(!filter_var($email, FILTER_SANITIZE_EMAIL)) $this->addError(["Hai inserito un {$display} non valido. Controlla {$email}", $item]);
						}
						break;
						// case 'ip':
						// 	if(!filter_var($value,FILTER_VALIDATE_IP)===false) $this->addError(["{$display} non è un indirizzo IP valido"], $item);
						// 	elseif($rule_value == 4) {
						// 		if(!filter_var($value,FILTER_VALIDATE_IP,FILTER_FLAG_IPV4)===false) $this->addError(["{$display} non è un indirizzo IPv4 valido"], $item);
						// 	} elseif($rule_value == 6) {
						// 		if(!filter_var($value,FILTER_VALIDATE_IP,FILTER_FLAG_IPV6)===false) $this->addError(["{$display} non è un indirizzo IPv6 valido"], $item);
						// 	}
						// 	break;

						case 'valid_base64': break; /* TDB */
					}
				}
			}
		}
		if(empty($this->_errors)) {
			$this->_passed = true;
		}
		return $this;
	}

	public function addError($error) {
		$this->_errors[] = $error;
		$this->_passed = (empty($this->_errors)) ? true : false;
	}

	public function errors() { return $this->_errors; }
	public function passed() { return $this->_passed; }
	public function displayErrors() {
		$type = 'danger';
		if(!empty($error)) {
			// Session::flash('danger',(is_array($error)?$error[0]:$error),'');
			$html = '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">';
			$html .= '<ul>';
			foreach($this->_errors as $error) {
				if(is_array($error)) {
					$html .= '<li class="text-'.$type.'">'.$error[0].'</li>';
					// $html .= '<script>jQuery("document").ready(function(){jQuery("#'.$error[1].'").parent().closest("div").addClass("has-error")})</script>';
				} else {
					$html .= '<li class="text-'.$type.'">'.$error.'</li>';
				}
			}
			$html .= '</ul></div>';
			return $html;
		}
		return null;
	}

	/**
	* Validate user input empty or not
	* @param mixed $str String to validate
	* @return bool
	*/
	public function required($str) { return $str ? 1 : 0; }

	/**
	* Check whether input value is exist between given range
	* @param string $str String to validate
	* @param  array  $options [values separated by -]
	* @return bool
	*/
	public function between($str,$options=array()) {
		$str = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
		list($min,$max) = explode("-",$options['condition']);
		return ($min <= $str && $max >= $str) ? 1 : 0;
	}

	public function pair($str) {
		$str = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
		return ((int) $str % 2 == 0);
	}

	public function odd($str) {
		$str = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
		return ((int) $str % 2 !== 0);
	}

	public function prime($str) {
		$str = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
		if (!is_numeric($str) || $str <= 1) return false;
		if ($str != 2 && ($str % 2) ==  0) return false;
		for ($i = 3; $i <= ceil(sqrt($str)); $i += 2) {
			if (($str % $i) == 0) return false;
		}
		return true;
	}

	// Check given string contains only alphabets & digits & special characters with specified length
	public function alnumSplonly($str,$options){
		$spl_chars = $alpha = $num = '';
		if(!empty($options)){
			if(isset($options['condition']['spl_chars'])) $spl_chars = $options['condition']['spl_chars'];
			if(isset($options['condition']['alpha'])) $alpha = $options['condition']['alpha'];
			if(isset($options['condition']['num'])) $num = $options['condition']['num'];
			// echo $spl_chars . $alpha . $num;
			$alphaCond = "/[a-zA-Z]{". $alpha ."}+/";
			$numCond = "/[0-9]{". $num ."}+/";
			$splCharsCond = "/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:'\<\>,\.\?\\\]{" . $spl_chars ."}+/";
			return (preg_match($alphaCond,$str) && preg_match($numCond,$str) && preg_match($splCharsCond, $str))?1:0;
		} else {
			$alphaNumCond = '/[a-zA-Z]+\d+/';
			$splCharsCond = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
			return (preg_match($alphaNumCond,$str) && preg_match($splCharsCond,$str))?1:0;
		}
	}

	// Check uploaded file extensions
	public function valid_extensions($str,$options=array()){
		$info = new SplFileInfo($str);
		return in_array($info->getExtension(),$options['condition'])?1:0;
	}

	// Check given value is float number or not
	public function floatonly($str){return (is_float($str))?1:0;}

	// Check date format
	public function dateFormat($str,$options=array()){
		$format = $options['condition'];
		$d = DateTime::createFromFormat($format,$str);
		return $d && $d->format($format) === $str ? 1 : false;
	}

	// Validate given date is below min date or  not
	public function minDate($str,$options=array()){
		$minDate = $options['condition'];
		$strObj = new DateTime($str);
		$minDateObj = new DateTime($minDate);
		$interval = $minDateObj->diff($strObj);
		$res = $interval->format('%R%a');
		return (strpos($res,"+") > -1 ) ? 1 : false;
	}

	// Validate given date is below max date or  not
	public function maxDate($str,$options=array()){
		$minDate = $options['condition'];
		$strObj = new DateTime($str);
		$minDateObj = new DateTime($minDate);
		$interval = $minDateObj->diff($strObj);
		$res = $interval->format('%R%a');
		return (strpos($res,"-") > -1 ) ? 1 : false;
	}

	// Validate given string matches with specified format
	public function checkFormat($str,$options=array()){
		$format = $options['condition'];
		$cond = "/$format$/";
		return ( preg_match($cond,$str ))  ? 1 : false;
	}

	public function codiceFiscale($cf) {
		if (strlen($cf)==11) { self::vat($cf); }
		elseif(!self::minLength($cf,[16])) return false;
		setCF($cf);
	}

	public function vat($vat) {
		if (!self::minLength($vat,[11])) return false;
		PartitaIVA::check('IT',$vat);
	}

	public function credit_card_number($ccn) {
		if (!self::minLenght($ccn,[16])) return false;
		CreditCard::validCreditCard($ccn);
	}

	public function credit_card_cvc($cvc) {
		CreditCard::validCvc($cvc);
	}

	public function credit_card_date($year, $month) {
		CreditCard::validDate($year, $month);
	}
}
?>
