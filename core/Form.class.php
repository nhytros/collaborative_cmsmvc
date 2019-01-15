<?php
class Form {
	private $tag, $xhtml;

	private function __construct() {}

	// public static function open($action = '', $method = 'post', $id = '', $attributes=[],$csrf=0) {
	// 	if($action='' || empty($action)) $action = base_url($_SERVER['PHP_SELF']);
	// 	$str = '<form action="'.$action.'" method="'.$method.'"';
	// 	if(!empty($id)) $str .= ' id="'.$id.'"';
	// 	$str .= $attributes ? self::addAttributes($attributes).'>' : '>';
	// 	$str .= ($csrf)?self::csrf():'';
	// 	return $str.PHP_EOL;
	// }

	public static function open($action='',$attributes=[],$hidden=[]) {
		if(!$action) {
			$action = base_url($_SERVER['PHP_SELF']);
		} elseif(strpos($action,'://') === false) {
			$action = base_url($action);
		}
		$attributes = self::AttsToString($attributes);
		if(stripos($attributes, 'method') === false) {
			$attributes .= ' method="post"';
		}
		if(stripos($attributes,'accept-charset') === false) {
			$attributes .= ' accept-charset="'.strtolower(config('charset')).'"';
		}
		$form = '<form action="'.$action.'"'.$attributes.">\n";
		if(is_array($hidden)) {
			foreach($hidden as $name => $value) {
				$form .= '<input type="hidden" name="'.$name.'" value="'.Input::sanitize($value).'" />'."\n";
			}
			if(config('csrf_protection') === true) {
				$form .= self::csrf();
			}
		}
		return $form;
	}

	public static function close() { return '</form>'; }

	public static function open_multipart($action='',$attributes=[],$hidden=[]) {
		if(is_string($attributes)) {
			$attributes .= ' enctype="multipart/form-data"';
		} else {
			$attributes['enctype'] = 'multipart/form-data';
		}
		return self::open($action,$attributes,$hidden);
	}

	// public static function input($type='text',$label,$name,$value='',$options=[],$divAttributes=[],$labelAttributes=[]) {
	// 	$val = '';
	// 	$divAttrs = self::addAttributes($divAttributes);
	// 	$optAttrs = self::addAttributes($options);
	// 	$lblAttrs = self::addAttributes($labelAttributes);
	// 	if($type != 'checkbox') {
	// 		$val = ' value="'.Input::sanitize($value).'" ';
	// 	}
	// 	$html = '<div'.$divAttrs.'>'.PHP_EOL;
	// 	$html .= '<input type="'.$type.'" name="'.$name.'" id="'.$name.'" '.$val.$optAttrs.' />'.PHP_EOL;
	// 	$html .= self::labelFor($name,$label,$lblAttrs);
	// 	//$html .= '<label for="'.$name.'">'.$label.'</label>';
	// 	$html .= '</div>'.PHP_EOL;
	// 	return $html;
	// }

	// public static function password($label,$name,$value='',$options=[],$divAttributes=[],$labelAttributes=[]) {
	// 	return self::input('password',$label,$name,Input::sanitize($value),$options,$divAttributes,$labelAttributes);
	// }

	// public static function hidden($name,$value=''/*,$options=[]*/) {
	// 	// $optAttrs = self::addAttributes($options);
	// 	return '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.Input::sanitize($value).'" '/*.$options*/.'/>'.PHP_EOL;
	// }

	public static function hidden($name, $value='',$recursing=false) {
		static $form;
		if($recursing === false) { $form = "\n"; }
		if(is_array($name)) {
			foreach($name as $key => $val) {
				self::hidden($key,$val,true);
			}
			return $form;
		}
		if(!is_array($value)) {
			$form .= '<input type="hidden" name="'.$name.'" value="'.Input::sanitize($value)."\" />\n";
		} else {
			foreach($value as $k => $v) {
				$k = is_int($k)?'':$k;
				self::hidden($name.'['.$k.']',$v,true);
			}
		}
		return $form;
	}

	public static function input($data='',$value='',$extra='') {
		$defaults = [
			'type'	=> 'text',
			'name'	=> is_array($data)?'':$data,
			'value'	=> $value
		];
		if(!in_array('id',$data)) $defaults['id'] = $data['name'];
		return '<input '.self::_parse_form_attributes($data,$defaults).self::AttsToString($extra)." />\n";
	}

	public static function password($data='',$value='',$extra='') {
		is_array($data) || $data = ['name'=>$data];
		$data['type'] = 'password';
		return self::input($data,$value,$extra);
	}

	public static function upload($data='',$value='',$extra='') {
		$defaults = ['type'=>'file','name'=>''];
		is_array($data) || $data = ['name'=>$data];
		$data['type'] = 'file';
		return '<input '.self::_parse_form_attributes($data,$defaults).self::AttsToString($extra)." /.\n";
	}

	public static function textarea($data='',$value='',$extra='') {
		$defaults = [
			'name'	=> is_array($data)?'':$data,
			'cols'	=> '0',
			'rows'	=> '3'
		];
		if(!in_array('id',$data)) $defaults['id'] = $data['name'];
		if(!is_array($data) || !isset($data['value'])) {
			$val = $value;
		} else {
			$val = $data['value'];
			unset($data['value']);
		}
		return '<textarea '.self::_parse_form_attributes($data, $defaults).self::AttsToString($extra).'>'
			.Input::sanitize($val)."</textarea>\n";
	}

	public static function multiselect($name='',$options=[],$selected=[],$extra='') {
		$extra = self::AttsToString($extra);
		if(stripos($extra,'multiple') === false) {
			$extra .= ' multiple="multiple"';
		}
		return self::dropdown($name,$options,$selected,$extra);
	}

	// public static function checkbox($label,$name,$value='',$options=[],$divAttributes=[],$labelAttributes=[]) {
	// 	return self::input('checkbox',$label,$name,Input::sanitize($value),$options,$divAttributes,$labelAttributes);
	// }

	public static function checkbox($data='',$value='',$checked=false,$extra='') {
		$defaults = ['type'=>'checkbox','name'=>(!is_array($data)?$data:''), 'value'=>$value];
		if(is_array($data) && array_key_exists('checked', $data)) {
			$checked = $data['checked'];
			if($checked == false) {
				unset($data['checked']);
			} else {
				$data['checked'] = 'checked';
			}
		}
		if($checked == true) {
			$defaults['checked'] = 'checked';
		} else {
			unset($defaults['checked']);
		}
		return '<input '.self::_parse_form_attributes($data,$defaults).self::AttsToString($extra)." />\n";
	}

	// public static function textarea($name, $rows=4, $cols=30, $value='', $attributes=[]) {
	// 	$str = '<textarea name="'.$name.'" id="'.$name.'" rows="'.$rows.'" cols="'.$cols.'"';
	// 	if ($attributes) $str .= self::addAttributes($attributes);
	// 	$str .= '>'.Input::sanitize($value).'</textarea>';
	// 	return $str;
	// }

	public static function radio($data='',$value='',$checked=false,$extra='') {
		is_array($data) || $data = ['name'=>$data];
		$data['type'] = 'radio';
		return self::checkbox($data,$value,$checked,$extra);
	}

	public static function dropdown($data='',$options=[],$selected=[],$extra='') {
		$defaults = [];
		if(is_array($data)) {
			if(isset($data['selected'])) {
				$selected = $data['selected'];
				unset($data['selected']);
			}
			if(isset($data['options'])) {
				$options = $data['options'];
				unset($data['options']);
			}
		} else {
			$defaults = ['name'=>$data];
		}
		is_array($selected) || $selected = [$selected];
		is_array($options) || $options = [$options];
		if(empty($selected)) {
			if(empty($data)) {
				if(isset($data['name'],$_POST[$data['name']])) {
					$selected=[$_POST[$data['name']]];
				}
			} elseif(isset($_POST[$data])) {
				$selected = [$_POST[$data]];
			}
		}
		if(!in_array('id',$data)) $data['id'] = $data['name'];
		$extra = self::AttsToString($extra);
		$multiple = (count($selected) > 1 && stripos($extra, 'multiple') === false) ? ' multiple="multiple"' : '';
		$form = '<select '.rtrim(self::_parse_form_attributes($data,$defaults)).$extra.$multiple.">\n";
		foreach($options as $key => $val) {
			$key = (string) $key;
			if(is_array($val)) {
				if(empty($val)) {
					continue;
				}
				$form .= '<optgroup label="'.$key."\">\n";
				foreach($val as $ogkey => $ogval) {
					$sel = in_array($ogkey, $selected) ? ' selected="selected"' : '';
					$form .= '<option value="'.Input::sanitize($ogkey).'"'.$sel.'>'
					.(string)$val."</option>\n";
				}
				$form .= "</optgroup>\n";
			} else {
				$form .= '<option value="'.Input::sanitize($key).'"'
				.(in_array($key,$selected) ? ' selected="selected"' : '').'>'
				.(string) $val."</option>\n";
			}
		}
		return $form."</select>\n";
	}

	public static function csrf() {
		return self::hidden('csrf_token',Hash::genToken());
	}

	public static function submit($data='',$value='',$extra='',$button=false,$reset=false) {
		$defaults = [
			'name'	=> is_array($data) ? '' : $data,
			'value'	=> Input::sanitize($value)
		];
		$defaults['type'] = (!$reset) ? 'submit' : 'reset';
		if(!in_array('id',$data)) $data['id'] = $data['name'];
		if($button) return '<button '.self::_parse_form_attributes($data,$defaults).self::AttsToString($extra).'>'.$value."</button>\n";
		return '<input '.self::_parse_form_attributes($data,$defaults).self::AttsToString($extra)." />\n";
	}

	public static function button($data='',$content='',$extra='') {
		$defaults = [
			'name'	=> is_array($data) ? '' : $data,
			'type'	=> 'button'
		];
		if(!in_array('id',$data)) $data['id'] = $data['name'];
		if(is_array($data) && isset($data['content'])) {
			$content = $data['content'];
			unset($data['content']);
		}
		return '<button '.self::_parse_form_attributes($data,$defaults).self::AttsToString($extra).'>'.$content."</button>\n";
	}

	public static function label($text='',$id='',$attributes=[]) {
		$label = '<label';
		if($id !== '') $label .= ' for="'.$id.'"';
		$label .= self::AttsToString($attri);
		return $label.'>'.$text.'</label>';
	}

	public static function fieldset($legend='',$attributes=[]) {
		$fieldset = '<fieldset'.self::AttsToString($attributes).">\n";
		if($legend !== '') return $fieldset.'<legend>'.$legend."</legend>\n";
		return $fieldset;
	}

	public static function fieldset_close($extra='') {
		return '</fieldset>'.$extra;
	}

	public static function posted_values($post) {
		$clean = [];
		foreach($post as $key => $value) {
			$clean[$key] = Input::sanitize($value);
		}
		return $clean;
	}

	public static function displayErrors($errors) {
		$type = 'danger';
		// $hasErrors = (!empty($errors))?' invalid-feedback':'';
		if(!empty($errors)) {
			// Session::flash('danger',(is_array($error)?$error[0]:$error),'');
			$html = '<div class="form-errors alert alert-'.$type.' alert-dismissible fade show" role="alert">';
			// $html .= '<ul class="bg-'.$type.$hasErrors.'">';
			$html .= '<ul>';
			foreach($errors as $field => $error) {
				$html .= '<li class="text-'.$type.'">'.$error.'</li>';
				// $html .= '<script>jQuery("document").ready(function(){jQuery("#'.$field.'").parent().closest("div").addClass("invalid-feedback")})</script>';
			}
			$html .= '</ul></div>';
			return $html;
		}
		return null;
	}

	private static function _parse_form_attributes($attributes, $default) {
		if(is_array($attributes)) {
			foreach($default as $key => $val) {
				if(isset($attributes[$key])) {
					$default[$key] = $attributes[$key];
					unset($attributes[$key]);
				}
			}
			if(count($attributes) > 0) {
				$default = array_merge($default,$attributes);
			}
		}
		$att = '';
		foreach($default as $key => $val) {
			if($key === 'value') {
				$val = Input::sanitize($val);
			} elseif($key === 'name' && !strlen($default['name'])) {
				continue;
			}
			$att .= $key.'="'.$val.'" ';
		}
		return $att;
	}

	private static function AttsToString($attributes) {
		if(empty($attributes)) { return ''; }
		if(is_object($attributes)) { $attributes = (array) $attributes; }
		if(is_array($attributes)) {
			$atts = '';
			foreach($attributes as $key => $val) {
				$atts .= ' '.$key.'="'.$val.'"';
			}
			return $atts;
		}
		if(is_string($attributes)) { return ' '.$attributes; }
		return false;
	}


}
